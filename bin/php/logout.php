<?php
session_start();
if(session_destroy()) {
  header("Location: /bin/index.php");
  die();
}
?>
