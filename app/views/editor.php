<html>
<head>
	<script src="/js/tinymce/tinymce.min.js"></script>
	<script src="/js/tinymce.config.js"></script>

	<link rel="stylesheet" href="/css/style.css" media="screen" title="Editor">
	<base dir="https://flh.fhwa.dot.gov">

</head>
<body>

  <form action="#" method="post">
  	<textarea name='code'>
      <?=$body?>
  	</textarea>
		<input type='hidden' name="URL" value="<?=$card?>">
		<input type="submit" value="Save">
  </form>

</body>
