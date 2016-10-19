<?php
/**
 *
 */
class Page
{
  public $domain;

  function __construct($domain)
  {
    $this->domain = $domain;
  }

  public function get($path)
  {
    $url = $domain . $path;
  	$html = file_get_html($url);
    return $html;
  }
}


 ?>
