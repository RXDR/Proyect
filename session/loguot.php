<?php
session_start();
if(!empty($_SESSION)){
    $_SESSION = array();
    session_destroy();
    header('Location: ../login.php');
  }
?>