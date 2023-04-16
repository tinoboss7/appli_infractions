<?php
  session_start();
  $identifiants['login']  = $identifiants['motDePasse'] = "";
  $message = "";
  $identifiants['login']        = isset($_POST['login'])?$_POST['login']:null;
  $identifiants['motDePasse']   = isset($_POST['motDePasse'])?$_POST['motDePasse']:null;

  function existeUtilisateur (array $identifiants) : bool {
      $ok     = false;
      $login  = $identifiants['login'];
      $mdp    = $identifiants['motDePasse'];     

      require_once '../Modele/connexion.php';
      $db   = new Connexion();
      $req  = "SELECT nom, prenom
                FROM  conducteur
                WHERE no_permis = :login
                AND   mdp = :mdp";
      $res  = $db->execSQL($req, [':login'=>$login, ':mdp'=>$mdp]);
	  if (isset($res[0])) { $ok = true; }
	  
	 /*  if ($login === 'UNIV57' && $mdp = 'Nitschke') { 
      $db_admin = new Connexion();
      $db_admin->setAdmin('UNIV57', 'nitschke');
      $ok = true; 
    } */
	  
      return $ok;
  }

  if (isset($_POST['Connexion'])){
    if (existeUtilisateur($identifiants)){
      $_SESSION['login'] = $identifiants['login'];
     /*  $db_admin=new Connexion();
      if($db_admin->estAdmin($identifiants['login'], $identifiant['motDePasse'])){
        header('location: adminInfraction.php');
      } */
      //$message = "Identification OK : login". $identifiants['login'] .' mdp : '.$identifiants['motDePasse'] ;
      header('location: accueil.php');
    }
    else
      $message = "Identification incorrecte. Essayez de nouveau.";
  }
  require_once('../vue/login.view.php')
 ?>

