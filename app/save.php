<?php
$url = $_POST['URL'];

if(strpos($url, '.htm') == false) {
  $url = $url . 'index.htm';
}
$name = str_replace("/",".", $url);

$trim = trim($name, '.');
$path = "../submited/" . $trim;
echo $path;

$myfile = fopen($path, "w") or die("Unable to open file!");
fwrite($myfile, $_POST['code']);
fclose($myfile);

?>
