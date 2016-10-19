<?php include_once('page.php'); ?>
<html>
<head>
	<script src="/js/tinymce/tinymce.min.js"></script>
	<script src="/js/tinymce.config.js"></script>

	<style>
		textarea{
			height: 100%;
		}
	</style>
	<base dir="https://flh.fhwa.dot.gov">

</head>
<body>
  <?php
  $page = new Page('https://flh.fhwa.dot.gov');

  $page->load('/');
  ?>

  <form action="submit.php" method="post">
  	<textarea name='code'>
      <?=$page->pull('#content-wrap');?>
  	</textarea>
  	<input type="submit" value="Publish">
  </form>

</body>
