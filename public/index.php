<?php
$alerts = array();

switch($_SERVER['REQUEST_METHOD'])
{
  case 'POST':
    include('../app/save.php');
    header("Location: " . $_SERVER['REQUEST_URI']);
    setcookie('saved', '1', time() + (5 * 30), "/"); //5 minute cookie
    exit();
  break;

  default:
    if(isset($_COOKIE['saved'])){
      $alerts[] = 'Saved!';
      setcookie('saved', "0", time() - 3600, "/"); //Delete cookie
    }

    include('../app/editor.php');

  break;
}

?>
