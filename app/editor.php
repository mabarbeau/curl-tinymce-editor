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
  ?>

  <form action="submit.php" method="post">
  	<textarea name='code'>
      <?=$page->pull('#content-wrap');?>
  	</textarea>
  	<input type="submit" value="Publish">
  </form>

</body>
