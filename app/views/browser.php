<style>
body{
  margin-bottom: 11vh;
}

div.edit{
  background-color: gray;
  text-align: center;
  position: fixed;
  left: 0;
  right: 0;
  bottom: 0;
  padding: 1em;
  font-size: 300%;
}

</style>
<html>
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
	<link rel="stylesheet" href="/css/style.css" media="screen" title="Editor">
  <base href="https://flh.fhwa.dot.gov/<?=$card?>"/>
</head>
<?=$body; ?>
<div class='edit'>
  <a href='http://<?=$_SERVER['HTTP_HOST']?>/edit/<?=$card?>'>
    Edit Page
  </a>
</div>
