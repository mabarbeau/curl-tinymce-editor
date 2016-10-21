<?php
require_once('../app/page.php');
require_once '../vendor/class.Diff.php';
require_once('../app/file.php');

$page = new Page('https://flh.fhwa.dot.gov');
$page->load('/');

$file = new File('test.htm', $page->output());
$file->save();

echo Diff::toTable(Diff::compareFiles('../submited/index.htm', '../submited/test.htm'));

 ?>
<style>
.diff td{
  vertical-align : top;
  white-space    : pre;
  white-space    : pre-wrap;
  font-family    : monospace;
}
</style>
