<head>
		<link rel="stylesheet" type="text/css" href='https://flh.fhwa.dot.gov/library/template/style/'>
		<link  rel="stylesheet" type="text/css" href='https://flh.fhwa.dot.gov/library/template/style/carousel.css'>

</head>

<?php
//var_dump($_POST);

$myfile = fopen("submited/newfile.html", "w") or die("Unable to open file!");
$txt = $_POST['URL'] . '#' .  $_POST['ID'] . "\n";
fwrite($myfile, $txt);
fwrite($myfile, $_POST['code']);
fclose($myfile);

?>
