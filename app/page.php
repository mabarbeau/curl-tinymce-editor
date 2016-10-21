<?php

/**
 *
 */
class Page
{
  protected $domain;
  protected $page;

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

    return $this->page;

  }

}

?>
