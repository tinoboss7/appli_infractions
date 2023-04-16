<?php 
 session_start();

 require_once('../vue/header.php');

  if (isset($_SESSION['login'])) { 
    if($_SESSION['login']  === 'root'){
      $message = "Bienvenue {$_SESSION['login']}";}
    else header('location: login.php');
   
  }
  else header('location: login.php');
  require_once('login.php')
?>