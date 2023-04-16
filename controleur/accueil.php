<?php
  session_start();
  require_once("../Modele/infractionDAO.class.php");

  $infractionDAO = new InfractionDAO();
  $m= new InfractionDAO();
  if(isset($_SESSION['login'])&& $_SESSION['login']==="root"){
    $infractionsPermis = $infractionDAO->getAll();
    

  }else $infractionsPermis = $infractionDAO->getNomPermis($_SESSION['login']);

  require_once('../vue/accueil.view.php');
 ?>