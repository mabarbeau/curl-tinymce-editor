<head>
	<link rel="stylesheet" type="text/css" href='https://flh.fhwa.dot.gov/library/template/style/'>
	<link  rel="stylesheet" type="text/css" href='https://flh.fhwa.dot.gov/library/template/style/carousel.css'>

  <title>The Office of Federal Lands Highway (FLH)</title>
  <script type="text/javascript" src="https://flh.fhwa.dot.gov/library/javascript/jquery.min.js"></script>
  <script type="text/javascript" src="https://flh.fhwa.dot.gov/library/javascript/jquery.jshowoff.min.js"></script>
  <link type="text/css" rel="stylesheet" href="https://flh.fhwa.dot.gov/library/template/style/carousel.css" media="all" />
  <!--[if lt IE 9]><style type="text/css">.jshowoff-controls { bottom: 29px; }</style><![endif]-->

	<link rel="stylesheet" type="text/css" media="screen" href="https://flh.fhwa.dot.gov//library/template/style/" />
	<link rel="stylesheet" type="text/css" media="print" href="https://flh.fhwa.dot.gov//library/template/style/print.css" />
	<!-- <base href="https://flh.fhwa.dot.gov/" target="_blank" /> -->
</head>


<?php
include_once('../app/page.php');
$html = file_get_contents('../submited/index.htm');

$page = new Page('https://flh.fhwa.dot.gov');
$page->load($_SERVER['REQUEST_URI']);
$page->push('#side', $html);
echo $page->output();
?>
