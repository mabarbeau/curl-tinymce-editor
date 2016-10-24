<?php
namespace App;

use App\File;
use App\Page;

class Model
{
  public function Page($path)
  {
    $file = new File($path);
    $file->renameUrl();
    $fullpath = $file->fullpath();

    if(!file_exists($fullpath)){
      //No local download from server
      $page = new Page('https://flh.fhwa.dot.gov/');
      $page->load($path);
    }else{
      //Load local file
      $page = new Page($file->path);
      $page->load($file->filename);
    }

    return $page->output();
  }
}
