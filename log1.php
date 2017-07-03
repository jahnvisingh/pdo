<?php
  session_start();
  session_destroy();
  unset($_SESSION['username']);
  header("location:signin1.php");
?>