<?php
$dir    = __DIR__ . '/../../submited';
$files = preg_grep('/^([^.])/', scandir($dir));

?>
<table>
  <?php foreach ($files as $file): ?>
    <?php
    $array = explode('.', $file);
    $last = $array[count($array) - 1];
    array_pop($array);
    $string = implode('/', $array);
    $full = $string .'.' . $last;
    ?>
    <tr>
      <td>
        <?=$full?>
      </td>
      <td>
        <a href='/editor/<?=$full?>' target="_blank">
          Edit
        </a>
      </td>
      <td>
        <a href='/browser/<?=$full?>' target="_blank">
          View
        </a>
      </td>
      <td>
          Delete
      </td>
    </tr>
  <?php endforeach;?>
</table>
