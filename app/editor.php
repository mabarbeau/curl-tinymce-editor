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
	$file->renameUrl();
	$fullpath = $file->fullpath();

	if(!file_exists($fullpath)){
		//No local download from server
		$page = new Page('https://flh.fhwa.dot.gov');
		$page->load($_SERVER['REQUEST_URI']);
	}else{
		//Load local file
		$alerts->add('Edit pending');
		$page = new Page($file->path);
		$page->load($file->filename);
	}

	$alerts->outputList();
	?>

  <form action="#" method="post">
  	<textarea name='code'>
      <?=$page->output();?>
  	</textarea>
		<input type='hidden' name="URL" value="<?=$_SERVER['REQUEST_URI']?>">
		<input type="submit" value="Save">
  </form>

</body>
