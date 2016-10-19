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
    echo 'push';
  }

  public function output()
  {
    // Dumps the internal DOM tree back into string
    $str = $this->page;

    // Print it!
    echo $this->page;

  }

  public function submit()
  {
    $myfile = fopen("submited/newfile.html", "w") or die("Unable to open file!");
    $txt = $_POST['URL'] . '#' .  $_POST['ID'] . "\n";
    fwrite($myfile, $txt);
    fwrite($myfile, $_POST['code']);
    fclose($myfile);
  }

}

?>
