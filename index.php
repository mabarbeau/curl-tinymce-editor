<html>
<head>
	<script src="/js/tinymce/tinymce.min.js"></script>
	<script>
	tinymce.init({
	  selector: 'textarea',
	  height: 600,
	  theme: 'modern',
	  plugins: [
		'advlist autolink lists link image charmap print preview hr anchor pagebreak',
		'searchreplace wordcount visualblocks visualchars code fullscreen',
		'insertdatetime media nonbreaking save table contextmenu directionality',
		'emoticons paste textcolor colorpicker textpattern '
	  ],
	  toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
	  toolbar2: 'print preview media | forecolor backcolor emoticons',
	  image_advtab: true,
	  relative_urls: true,
	  document_base_url: '//flh.fhwa.dot.gov/',
	  content_css: [
		'https://flh.fhwa.dot.gov/library/template/style/',
		 'https://flh.fhwa.dot.gov/library/template/style/carousel.css'
	  ]
	});
	</script>

	<style>
		textarea{
			height: 100%;
		}
	</style>
	<base dir="https://flh.fhwa.dot.gov">

</head>
<body>

<?php
include('vendor/simple_html_dom.php');

$url='https://flh.fhwa.dot.gov';
$id='content-wrap';

if (isset($_GET['url'])) {
	$url= $_GET['url'];
}
if (isset($_GET['id'])) {
	$id=$_GET['id'];
}

?>


<form action="#" method="get">
	<lable>URL</lable>
	<input type='text' name="url" value="<?php echo $url?>" placeholder='Enter URL here'>
	<lable>Element ID</lable>
	<input type='text' name="id" value='<?php echo $id?>' placeholder='ID'>
	<input type="submit" value="Get page">
</form>
<form action="submit.php" method="post">
	<textarea name='code'>
<?php
	// get DOM from URL or file
	$html = file_get_html($url);
	foreach($html->find("div#" . $id) as $e)
	echo $e->innertext . '<br>';
?>

	</textarea>
	<input type='hidden' name="URL" value="<?php echo $url?>" placeholder='Enter URL here'>
	<input type='hidden' name="ID" value='<?php echo $id?>' placeholder='ID'>
	<input type="submit" value="Publish">
</form>


</body>
</html>
