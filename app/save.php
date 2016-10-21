<?php
include_once('file.php');
$file = new File($_POST['URL'], $_POST['code']);
$file->renameUrl()->save();
?>
