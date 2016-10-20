<?php

switch($_SERVER['REQUEST_METHOD'])
{
  case 'POST':
    include('../app/save.php');
    header("Location: " . $_SERVER['REQUEST_URI']);
    setcookie($_SERVER['REQUEST_URI'], '1', time() + (5 * 30), "/"); //5 minutes
    exit();
  break;

  default:
    if(isset($_COOKIE[$_SERVER['REQUEST_URI']])){
      echo 'Saved!';
      setcookie($_SERVER['REQUEST_URI'], "", time() - 3600);
    }

    include('../app/editor.php');

  break;
}

?>
