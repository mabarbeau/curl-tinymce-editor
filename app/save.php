<?php
include_once('page.php');

$url = trim($_POST['URL'], '/');
echo 'URL :' . $url . ':<hr>';

if(strlen($url) === 0) {
  $urlPath = 'index.htm';

}elseif(strpos($url, '.htm') == false) {
  $urlPath = $url . '/index.htm';

}else{
  $urlPath = $url;

}

$name = str_replace("/",".", $urlPath);

$save = "../submited/" . $name;
echo $save;

$file = fopen($save, "w") or die("Unable to open file!");
fwrite($file, $_POST['code']);
fclose($file);

?>
