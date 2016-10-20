<button type="button" name="edit" onclick="toggleEdit()">Edit Page</button>

<?php
include_once('../app/page.php');

$page = new Page('https://flh.fhwa.dot.gov');
$page->load($_SERVER['REQUEST_URI']);

echo $page->output();

?>

<style>
  button{
    width: 99vw;
    height: 10vh;
    font-size: 300%;
  }
</style>
