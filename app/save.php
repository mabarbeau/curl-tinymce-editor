<?php
$file = new File($_POST['URL'], $_POST['code']);
$file->renameUrl()->save();
?>
