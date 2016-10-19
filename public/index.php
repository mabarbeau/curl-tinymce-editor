<?php

switch($_SERVER['REQUEST_METHOD'])
{
  case 'POST':
    include('../app/save.php');
  break;

  case 'GET':
    include('../app/editor.php');
  break;

  default:
    header('HTTP/1.1 405 Method Not Allowed');
    header('Allow: GET, POST');
  break;
}


?>
