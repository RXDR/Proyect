<?php 
session_start();

if(empty($_SESSION) || ($_SESSION['perfil'] != 1 && $_SESSION['perfil'] != 2 && $_SESSION['perfil'] != 3)){
  
  header('Location: login.php');
  
}

?>