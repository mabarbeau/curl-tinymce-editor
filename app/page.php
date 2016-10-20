<?php

include_once('../vendor/simple_html_dom.php');
/**
 *
 */
class Page
{
  protected $domain;
  protected $page;
  public $html;
  public $content;

  function __construct($domain)
  {
    $this->domain = $domain;
  }

  public function load($path)
  {
    $url = $this->domain . $path;
  	$this->page = file_get_html($url);
  }


  public function pull($id)
  {
    foreach($this->page->find($id) as $e){
      echo $e->innertext . '<br>';
    }
  }

  public function push($id, $content)
  {
    foreach($this->page->find($id) as $e){
      $e->innertext = $content;
    }

  }

  public function output()
  {
    // Dumps the internal DOM tree back into string
    $str = $this->page;

    // Print it!
    echo $this->page;

  }


  public function URL_rename($url)
  {
    $url = trim($url, '/');

    if(strlen($url) === 0) {
      $urlPath = 'index.htm';

    }elseif(strpos($url, '.htm') == false) {
      $urlPath = $url . '/index.htm';

    }else{
      $urlPath = $url;
    }

    $name = str_replace("/",".", $urlPath);

    $save = "../submited/" . $name;

    return $save;
  }

}

?>
