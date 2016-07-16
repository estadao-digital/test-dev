<?php
  $text = $_POST['text'];
  $file = $_POST['file'];
  $handle = fopen($file, 'w');
  fwrite($handle, $text);
  fclose($handle);
?>