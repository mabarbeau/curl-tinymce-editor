<?php
$dir    = __DIR__ . '/../../submited';
$files = preg_grep('/^([^.])/', scandir($dir));

?>
<ul>
  <?php foreach ($files as $file): ?>
    <li>
      <?=$file?>
    </li>
  <?php endforeach;?>
</ul>
