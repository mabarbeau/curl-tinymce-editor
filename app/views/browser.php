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
<base href="https://flh.fhwa.dot.gov/<?=$card?>"/>
<?=$body; ?>
<div class='edit'>
  <a href='http://<?=$_SERVER['HTTP_HOST']?>/editor/<?=$card?>'>
    Edit Page
  </a>
</div>
