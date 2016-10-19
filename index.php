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
