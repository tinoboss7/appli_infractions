<?php

$op 	= (isset($_GET['op'])?$_GET['op']:null);
$ajout 	= ($op == 'a');
$modif 	= ($op == 'm');
$suppr 	= ($op == 's');
$num	= (isset($_GET['num'])?$_GET['num']:null);
$editNum= $ajout;


if ( ($idInf!=null && $ajout) || (($num=null) && $modif || $suppr) ) {
	header("location: adminInfraction.php");
} 



require_once('../Modele/infractionDAO.class.php');
$infractionDAO = new InfractionDAO();

// gestion des zones non modifiables en mode "modif"
$valeurs['num'] = null;
if ($modif)	{
	$valeurs['num'] = $num;
	$uneInfraction = $infractionDAO->getById($valeurs['num']);
}
if ($editNum) {
	$valeurs['num'] = (isset($_POST['num'])?trim($_POST['num']):$valeurs['num']);
}


$titre = (($ajout)?'Nouvelle Infraction':(($modif)?"Infraction - édition des informations":null));

$erreurs = ['num'=>"", 'Date'=>'', 'matricule'=>"",  'permis'=>""];
$valeurs['Date'] = (isset($_POST['date'])?trim($_POST['date']):null);
$valeurs['matricule'] = (isset($_POST['matricule'])?trim($_POST['matricule']):null);
$valeurs['permis'] = (isset($_POST['permis'])?trim($_POST['permis']):null);

$retour = false;
	
if (isset($_POST['valider'])) {
	if (!isset($valeurs['num']) or strlen($valeurs['num'])==0) 	{ $erreurs['num']	= 'saisie obligatoire du numéro';	}
	else if ($editNum and $infractionDAO->existe($valeurs['num'])) 	{ $erreurs['num'] 	= 'Numéro infraction déjà existant.';	}
	


 	$nbErreurs = 0;
 	foreach ($erreurs as $erreur){
 		if ($erreur != "") $nbErreurs++;
 	}
	require_once('../Modele/delitByInfractionDAO.php');
 	if ($nbErreurs == 0){
		$uneInfraction = new Infraction($valeurs['num'],$valeurs['date'], $valeurs['matricule'], $valeurs['permis']);
		$retour = true;
		if ($ajout)	{
			$infractionDAO->insert($uneInfraction);
		}	
		else {			
			$infractionDAO->update($uneInfraction);
		}
	}
}
else if (isset($_POST['annuler']))	{
	$retour = true;
}
else if ($suppr) {
// suppression
	$infractionDAO->delete($num);
	$retour = true;
}
else if ($modif)	{
	$uneInfraction = $infractionDAO->getById($num);
	$valeurs['num']		= $uneInfraction->getIdInf();
	$valeurs['date_inf'] = $uneInfraction->getDateInf();		
	$valeurs['no_immat'] 	= $uneInfraction->getNumImmat();
	$valeurs['no_permis'] 	= $uneInfraction->getNoPermis();		
}


if ($retour)
{
	header("location: adminInfraction.php");
}	

require_once("../vue/editInfraction.view.php");
?>