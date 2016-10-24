<?php
use App\Model;
use App\File;


function admin($request)
{
  include('views/admin.php');
}


function edit($request)
{
  if(isset($_COOKIE['saved'])){
      echo 'Saved!';
      setcookie('saved', "0", time() - 3600, "/"); //Delete cookie
  }

  $card = $request->getAttribute('card');
  $card = implode($card, '/');

  $model = new Model;
  $body = $model->Page($card);

  include('views/editor.php');
}


function save($request)
{
  $file = new File($_POST['URL'], $_POST['code']);
  $file->renameUrl()->save();
  header("Location: " . $_SERVER['REQUEST_URI']);
  setcookie('saved', '1', time() + (5 * 30), "/"); //5 minute cookie
  exit();

}


function view($request)
{
  $card = $request->getAttribute('card');
  $card = implode($card, '/');

  $model = new Model;
  $body = $model->Page($card);

  include('views/browser.php');
}
