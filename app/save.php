<?php
include_once('page.php');
$page = new Page('https://flh.fhwa.dot.gov');

$save = $page->URL_rename($_POST['URL']);

$file = fopen($save, "w") or die("Unable to open file!");
fwrite($file, $_POST['code']);
fclose($file);

?>
