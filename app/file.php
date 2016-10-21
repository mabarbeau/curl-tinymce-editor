<?php
/**
 *
 */
class File
{
  public $filename;
  protected $content;
  public $path = '../submited/';

  function __construct($filename, $content = '')
  {
     $this->filename = $filename;
     $this->content = $content;
  }
  public function save()
  {
    $filepath = $this->fullpath();
    $file = fopen($filepath, "w") or die("Unable to open file!");
    fwrite($file, $this->content);
    fclose($file);
    return $this;
  }

  public function fullpath()
  {
    $filepath = $this->path . $this->filename;
    return $filepath;
  }

  public function renameUrl()
  {
    $url = trim($this->filename, '/');

    if(strlen($url) === 0) {
      //If URL length 0 we are on home page
      $urlPath = 'index.htm';

    }elseif(strpos($url, '.htm') == false) {
      //No file extension
      $urlPath = $url . '/index.htm';
      //I.E. programs -> programs/index.htm

    }else{
      //Unmodified
      //I.E. programs/docs.htm
      $urlPath = $url;

    }

    //Replace '/' with '.'
    //So we don't need to deal with folders
    $this->filename = str_replace("/",".", $urlPath);
    return $this;

  }

}
