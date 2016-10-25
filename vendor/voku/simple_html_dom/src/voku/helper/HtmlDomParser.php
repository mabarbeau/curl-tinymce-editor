<?php

namespace voku\helper;

use BadMethodCallException;
use DOMDocument;
use DOMXPath;
use InvalidArgumentException;
use RuntimeException;

/**
 * Class HtmlDomParser
 *
 * @package voku\helper
 *
 * @property-read string outerText Get dom node's outer html (alias for "outerHtml")
 * @property-read string outerHtml Get dom node's outer html
 * @property-read string innerText Get dom node's inner html (alias for "innerHtml")
 * @property-read string innerHtml Get dom node's inner html
 * @property-read string plaintext Get dom node's plain text
 *
 * @method string outerText() Get dom node's outer html (alias for "outerHtml()")
 * @method string outerHtml() Get dom node's outer html
 * @method string innerText() Get dom node's inner html (alias for "innerHtml()")
 * @method HtmlDomParser load() load($html) Load HTML from string
 * @method HtmlDomParser load_file() load_file($html) Load HTML from file
 *
 * @method static HtmlDomParser file_get_html() file_get_html($html, $libXMLExtraOptions = null) Load HTML from file
 * @method static HtmlDomParser str_get_html() str_get_html($html, $libXMLExtraOptions = null) Load HTML from string
 */
class HtmlDomParser
{
  /**
   * @var array
   */
  protected static $functionAliases = array(
      'outertext' => 'html',
      'outerhtml' => 'html',
      'innertext' => 'innerHtml',
      'innerhtml' => 'innerHtml',
      'load'      => 'loadHtml',
      'load_file' => 'loadHtmlFile',
  );

  /**
   * @var array
   */
  protected static $domLinkReplaceHelper = array(
      'orig' => array('[', ']', '{', '}',),
      'tmp'  => array(
          '!!!!HTML_DOM__SQUARE_BRACKET_LEFT!!!!',
          '!!!!HTML_DOM__SQUARE_BRACKET_RIGHT!!!!',
          '!!!!HTML_DOM__BRACKET_LEFT!!!!',
          '!!!!HTML_DOM__BRACKET_RIGHT!!!!',
      ),
  );

  /**
   * @var array
   */
  protected static $domReplaceHelper = array(
      'orig' => array('&', '|', '+', '%'),
      'tmp'  => array(
          '!!!!HTML_DOM__AMP!!!!',
          '!!!!HTML_DOM__PIPE!!!!',
          '!!!!HTML_DOM__PLUS!!!!',
          '!!!!HTML_DOM__PERCENT!!!!',
      ),
  );

  /**
   * @var Callable
   */
  protected static $callback;

  /**
   * @var DOMDocument
   */
  protected $document;

  /**
   * @var string
   */
  protected $encoding = 'UTF-8';

  /**
   * @var bool
   */
  protected $isDOMDocumentCreatedWithoutHtml = false;

  /**
   * @var bool
   */
  protected $isDOMDocumentCreatedWithoutHtmlWrapper = false;

  /**
   * An random md5-hash, generated via "random_bytes()".
   *
   * @var string
   */
  protected $randomHash;

  /**
   * Constructor
   *
   * @param string|SimpleHtmlDom|\DOMNode $element HTML code or SimpleHtmlDom, \DOMNode
   */
  public function __construct($element = null)
  {
    $this->randomHash = md5(Bootup::get_random_bytes(16));
    $this->document = new \DOMDocument('1.0', $this->getEncoding());

    $this->addRandBytesToDomReplaceHelpers();

    // DOMDocument settings
    $this->document->preserveWhiteSpace = true;
    $this->document->formatOutput = true;

    if ($element instanceof SimpleHtmlDom) {
      $element = $element->getNode();
    }

    if ($element instanceof \DOMNode) {
      $domNode = $this->document->importNode($element, true);

      if ($domNode instanceof \DOMNode) {
        $this->document->appendChild($domNode);
      }

      return;
    }

    if ($element !== null) {
      $this->loadHtml($element);
    }
  }

  /**
   * Add rand-bytes to the "Dom-Replace-Helper"-variables.
   */
  protected function addRandBytesToDomReplaceHelpers()
  {
    foreach (self::$domLinkReplaceHelper['tmp'] as &$linkHelper) {
      $linkHelper .= $this->randomHash;
    }

    foreach (self::$domReplaceHelper['tmp'] as &$domHelper) {
      $domHelper .= $this->randomHash;
    }
  }

  /**
   * @param $name
   * @param $arguments
   *
   * @return bool|mixed
   */
  public function __call($name, $arguments)
  {
    $name = strtolower($name);

    if (isset(self::$functionAliases[$name])) {
      return call_user_func_array(array($this, self::$functionAliases[$name]), $arguments);
    }

    throw new BadMethodCallException('Method does not exist: ' . $name);
  }

  /**
   * @param $name
   * @param $arguments
   *
   * @return HtmlDomParser
   */
  public static function __callStatic($name, $arguments)
  {
    $arguments0 = null;
    if (isset($arguments[0])) {
      $arguments0 = $arguments[0];
    }

    $arguments1 = null;
    if (isset($arguments[1])) {
      $arguments1 = $arguments[1];
    }

    if ($name == 'str_get_html') {
      $parser = new self();

      return $parser->loadHtml($arguments0, $arguments1);
    }

    if ($name == 'file_get_html') {
      $parser = new self();

      return $parser->loadHtmlFile($arguments0, $arguments1);
    }

    throw new BadMethodCallException('Method does not exist');
  }

  /**
   * @param $name
   *
   * @return string
   */
  public function __get($name)
  {
    $name = strtolower($name);

    switch ($name) {
      case 'outerhtml':
      case 'outertext':
        return $this->html();
      case 'innerhtml':
      case 'innertext':
        return $this->innerHtml();
      case 'text':
      case 'plaintext':
        return $this->text();
    }

    return null;
  }

  /**
   * @param string $selector
   * @param int    $idx
   *
   * @return SimpleHtmlDom|SimpleHtmlDomNode|null
   */
  public function __invoke($selector, $idx = null)
  {
    return $this->find($selector, $idx);
  }

  /**
   * @return string
   */
  public function __toString()
  {
    return $this->html();
  }

  /**
   * does nothing (only for api-compatibility-reasons)
   *
   * @return bool
   */
  public function clear()
  {
    return true;
  }

  /**
   * @param string $html
   *
   * @return string
   */
  public static function replaceToPreserveHtmlEntities($html)
  {
    // init
    $linksNew = array();
    $linksOld = array();

    if (strpos($html, 'http') !== false) {
      preg_match_all("/(\bhttps?:\/\/[^\s()<>]+(?:\([\w\d]+\)|[^[:punct:]\s]|\/|\}|\]))/i", $html, $linksOld);

      if (!empty($linksOld[1])) {
        $linksOld = $linksOld[1];
        foreach ($linksOld as $linkKey => $linkOld) {
          $linksNew[$linkKey] = str_replace(
              self::$domLinkReplaceHelper['orig'],
              self::$domLinkReplaceHelper['tmp'],
              $linkOld
          );
        }
      }
    }

    $linksNewCount = count($linksNew);
    if ($linksNewCount > 0 && count($linksOld) === $linksNewCount) {
      $search = array_merge($linksOld, self::$domReplaceHelper['orig']);
      $replace = array_merge($linksNew, self::$domReplaceHelper['tmp']);
    } else {
      $search = self::$domReplaceHelper['orig'];
      $replace = self::$domReplaceHelper['tmp'];
    }

    return str_replace($search, $replace, $html);
  }

  /**
   * @param string $html
   *
   * @return string
   */
  public static function putReplacedBackToPreserveHtmlEntities($html)
  {
    return str_replace(
        array_merge(
            self::$domLinkReplaceHelper['tmp'],
            self::$domReplaceHelper['tmp'],
            array('&#13;')
        ),
        array_merge(
            self::$domLinkReplaceHelper['orig'],
            self::$domReplaceHelper['orig'],
            array('')
        ),
        $html
    );
  }

  /**
   * create DOMDocument from HTML
   *
   * @param string   $html
   * @param int|null $libXMLExtraOptions
   *
   * @return \DOMDocument
   */
  private function createDOMDocument($html, $libXMLExtraOptions = null)
  {
    if (strpos($html, '<') === false) {
      $this->isDOMDocumentCreatedWithoutHtml = true;
    }

    if (strpos($html, '<html') === false) {
      $this->isDOMDocumentCreatedWithoutHtmlWrapper = true;
    }

    // set error level
    $internalErrors = libxml_use_internal_errors(true);
    $disableEntityLoader = libxml_disable_entity_loader(true);
    libxml_clear_errors();

    $options = LIBXML_DTDLOAD | LIBXML_DTDATTR | LIBXML_NONET;

    if (defined('LIBXML_COMPACT')) {
      $options |= LIBXML_COMPACT;
    }

    if (defined('LIBXML_HTML_NOIMPLIED')) {
      $options |= LIBXML_HTML_NOIMPLIED;
    }

    if (defined('LIBXML_HTML_NODEFDTD')) {
      $options |= LIBXML_HTML_NODEFDTD;
    }

    if ($libXMLExtraOptions !== null) {
      $options |= $libXMLExtraOptions;
    }

    $sxe = simplexml_load_string($html, 'SimpleXMLElement', $options);
    if ($sxe !== false && count(libxml_get_errors()) === 0) {
      $this->document = dom_import_simplexml($sxe)->ownerDocument;
    } else {

      // UTF-8 hack: http://php.net/manual/en/domdocument.loadhtml.php#95251
      $html = trim($html);
      $xmlHackUsed = false;
      if (stripos('<?xml', $html) !== 0) {
        $xmlHackUsed = true;
        $html = '<?xml encoding="' . $this->getEncoding() . '" ?>' . $html;
      }

      $html = self::replaceToPreserveHtmlEntities($html);

      $this->document->loadHTML($html);

      // remove the "xml-encoding" hack
      if ($xmlHackUsed === true) {
        foreach ($this->document->childNodes as $child) {
          if ($child->nodeType == XML_PI_NODE) {
            $this->document->removeChild($child);
          }
        }
      }

      libxml_clear_errors();
    }

    // set encoding
    $this->document->encoding = $this->getEncoding();

    // restore lib-xml settings
    libxml_use_internal_errors($internalErrors);
    libxml_disable_entity_loader($disableEntityLoader);

    return $this->document;
  }

  /**
   * Return SimpleHtmlDom by id.
   *
   * @param string $id
   *
   * @return SimpleHtmlDom|SimpleHtmlDomNodeBlank
   */
  public function getElementById($id)
  {
    return $this->find("#$id", 0);
  }

  /**
   * Return SimpleHtmlDom by tag name.
   *
   * @param string $name
   *
   * @return SimpleHtmlDom|SimpleHtmlDomNodeBlank
   */
  public function getElementByTagName($name)
  {
    $node = $this->document->getElementsByTagName($name)->item(0);

    if ($node !== null) {
      return new SimpleHtmlDom($node);
    } else {
      return new SimpleHtmlDomNodeBlank();
    }
  }

  /**
   * Returns Elements by id
   *
   * @param string   $id
   * @param null|int $idx
   *
   * @return SimpleHtmlDomNode|SimpleHtmlDomNode[]|SimpleHtmlDomNodeBlank
   */
  public function getElementsById($id, $idx = null)
  {
    return $this->find("#$id", $idx);
  }

  /**
   * Returns Elements by tag name
   *
   * @param string   $name
   * @param null|int $idx
   *
   * @return SimpleHtmlDomNode|SimpleHtmlDomNode[]|SimpleHtmlDomNodeBlank
   */
  public function getElementsByTagName($name, $idx = null)
  {
    $nodesList = $this->document->getElementsByTagName($name);

    $elements = new SimpleHtmlDomNode();

    foreach ($nodesList as $node) {
      $elements[] = new SimpleHtmlDom($node);
    }

    if (null === $idx) {
      return $elements;
    } else {
      if ($idx < 0) {
        $idx = count($elements) + $idx;
      }
    }

    if (isset($elements[$idx])) {
      return $elements[$idx];
    } else {
      return new SimpleHtmlDomNodeBlank();
    }
  }

  /**
   * Find list of nodes with a CSS selector.
   *
   * @param string $selector
   * @param int    $idx
   *
   * @return SimpleHtmlDom|SimpleHtmlDom[]|SimpleHtmlDomNodeBlank
   */
  public function find($selector, $idx = null)
  {
    $xPathQuery = SelectorConverter::toXPath($selector);

    $xPath = new DOMXPath($this->document);
    $nodesList = $xPath->query($xPathQuery);
    $elements = new SimpleHtmlDomNode();

    foreach ($nodesList as $node) {
      $elements[] = new SimpleHtmlDom($node);
    }

    if (null === $idx) {
      return $elements;
    } else {
      if ($idx < 0) {
        $idx = count($elements) + $idx;
      }
    }

    if (isset($elements[$idx])) {
      return $elements[$idx];
    } else {
      return new SimpleHtmlDomNodeBlank();
    }
  }

  /**
   * @param string $content
   *
   * @return string
   */
  protected function fixHtmlOutput($content)
  {
    // INFO: DOMDocument will encapsulate plaintext into a paragraph tag (<p>),
    //          so we try to remove it here again ...

    if ($this->isDOMDocumentCreatedWithoutHtmlWrapper === true) {
      $content = str_replace(
          array(
              "\n",
              "\r\n",
              "\r",
              '<simpleHtmlDomP>',
              '</simpleHtmlDomP>',
              '<body>',
              '</body>',
              '<html>',
              '</html>',
          ),
          '',
          $content
      );
    }

    if ($this->isDOMDocumentCreatedWithoutHtml === true) {
      $content = str_replace(
          array(
              '<p>',
              '</p>',
              '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">'
          ),
          '',
          $content);
    }

    $content = UTF8::html_entity_decode($content);
    $content = trim($content);
    $content = UTF8::rawurldecode($content);

    $content = self::putReplacedBackToPreserveHtmlEntities($content);

    return $content;
  }

  /**
   * @return DOMDocument
   */
  public function getDocument()
  {
    return $this->document;
  }

  /**
   * Get the encoding to use
   *
   * @return string
   */
  private function getEncoding()
  {
    return $this->encoding;
  }

  /**
   * @return bool
   */
  public function getIsDOMDocumentCreatedWithoutHtml()
  {
    return $this->isDOMDocumentCreatedWithoutHtml;
  }

  /**
   * @return bool
   */
  public function getIsDOMDocumentCreatedWithoutHtmlWrapper()
  {
    return $this->isDOMDocumentCreatedWithoutHtmlWrapper;
  }

  /**
   * Get dom node's outer html
   *
   * @return string
   */
  public function html()
  {
    if ($this::$callback !== null) {
      call_user_func_array($this::$callback, array($this));
    }

    if ($this->getIsDOMDocumentCreatedWithoutHtmlWrapper()) {
      $content = $this->document->saveHTML($this->document->documentElement);
    } else {
      $content = $this->document->saveHTML();
    }

    return $this->fixHtmlOutput($content);
  }

  /**
   * Get the HTML as XML.
   *
   * @return string
   */
  public function xml()
  {
    $xml = $this->document->saveXML(null, LIBXML_NOEMPTYTAG);

    // remove the XML-header
    $xml = ltrim(preg_replace('/<\?xml.*\?>/', '', $xml));

    return $this->fixHtmlOutput($xml);
  }

  /**
   * Get dom node's inner html
   *
   * @return string
   */
  public function innerHtml()
  {
    $text = '';

    foreach ($this->document->documentElement->childNodes as $node) {
      $text .= $this->fixHtmlOutput($this->document->saveHTML($node));
    }

    return $text;
  }

  /**
   * Load HTML from string
   *
   * @param string   $html
   * @param int|null $libXMLExtraOptions
   *
   * @return HtmlDomParser
   *
   * @throws InvalidArgumentException if argument is not string
   */
  public function loadHtml($html, $libXMLExtraOptions = null)
  {
    if (!is_string($html)) {
      throw new InvalidArgumentException(__METHOD__ . ' expects parameter 1 to be string.');
    }

    $this->document = $this->createDOMDocument($html, $libXMLExtraOptions);

    return $this;
  }

  /**
   * Load HTML from file
   *
   * @param string   $filePath
   * @param int|null $libXMLExtraOptions
   *
   * @return HtmlDomParser
   */
  public function loadHtmlFile($filePath, $libXMLExtraOptions = null)
  {
    if (!is_string($filePath)) {
      throw new InvalidArgumentException(__METHOD__ . ' expects parameter 1 to be string.');
    }

    if (!preg_match("/^https?:\/\//i", $filePath) && !file_exists($filePath)) {
      throw new RuntimeException("File $filePath not found");
    }

    try {
      $html = UTF8::file_get_contents($filePath);

    } catch (\Exception $e) {
      throw new RuntimeException("Could not load file $filePath");
    }

    if ($html === false) {
      throw new RuntimeException("Could not load file $filePath");
    }

    $this->loadHtml($html, $libXMLExtraOptions);

    return $this;
  }

  /**
   * Save dom as string
   *
   * @param string $filepath
   *
   * @return string
   */
  public function save($filepath = '')
  {
    $string = $this->innerHtml();
    if ($filepath !== '') {
      file_put_contents($filepath, $string, LOCK_EX);
    }

    return $string;
  }

  /**
   * @param $functionName
   */
  public function set_callback($functionName)
  {
    $this::$callback = $functionName;
  }

  /**
   * Get dom node's plain text
   *
   * @return string
   */
  public function text()
  {
    return $this->fixHtmlOutput($this->document->textContent);
  }
}
