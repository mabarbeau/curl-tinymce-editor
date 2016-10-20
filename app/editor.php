<?php include_once('page.php'); ?>
<?php include_once('file.php'); ?>
<html>
<head>
	<script src="/js/tinymce/tinymce.min.js"></script>
	<script src="/js/tinymce.config.js"></script>

	<link rel="stylesheet" href="/css/style.css" media="screen" title="Editor">
	<base dir="https://flh.fhwa.dot.gov">

</head>
<body>
  <?php
	$file = new File($_SERVER['REQUEST_URI']);
	$file->URL_rename();
	$fullpath = $file->fullpath();

	if(!file_exists($fullpath)){
		//No local download from server
		$page = new Page('https://flh.fhwa.dot.gov');
		$page->load($_SERVER['REQUEST_URI']);
	}else{
		//Load local file
		$alerts[] = 'Edit pending';
		$page = new Page($file->path);
		$page->load($file->filename);
	}
	?>


	<?php if(!empty($alerts)):?>
		<ul>
			<li>
				<?=implode('</li><li>', $alerts);?>
			</li>
		</ul>
	<?php endif; ?>


  <form action="#" method="post">
  	<textarea name='code'>
      <?=$page->output();?>
  	</textarea>
		<input type='hidden' name="URL" value="<?=$_SERVER['REQUEST_URI']?>">
		<input type="submit" value="Save">
  </form>

</body>
