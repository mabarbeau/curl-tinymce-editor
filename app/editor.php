<?php include_once('page.php'); ?>
<html>
<head>
	<script src="/js/tinymce/tinymce.min.js"></script>
	<script src="/js/tinymce.config.js"></script>

	<link rel="stylesheet" href="/css/style.css" media="screen" title="Editor">
	<base dir="https://flh.fhwa.dot.gov">

</head>
<body>
  <?php
  $page = new Page('https://flh.fhwa.dot.gov');
  $page->load($_SERVER['REQUEST_URI']);
	// var_dump($_SERVER);
  ?>


  <form action="#" method="post">
  	<textarea name='code'>
      <?=$page->output();?>
  	</textarea>
		<input type='hidden' name="URL" value="<?=$_SERVER['REQUEST_URI']?>">
  	<input type="submit" value="Publish">
  </form>

</body>
