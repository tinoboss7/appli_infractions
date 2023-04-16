<?php

$op 	= (isset($_GET['op'])?$_GET['op']:null);
$ajout 	= ($op == 'a');
$modif 	= ($op == 'm');
$suppr 	= ($op == 's');
$num = (isset($_GET['num'])?$_GET['num']:null);
$id = (isset($_GET['id_inf'])?$_GET['id_inf']:null);
$editNature = $ajout;

// accès à la page uniquement si un numéro infraction et statut opération sont passés en paramètre
if ( $num==null || ($id!=null && $ajout) || (($id=null) && $modif || $suppr) ) {
	header("location: adminInfraction.php");
} 



$nature = [];
require_once('../modele/delitDAO.class.php');
$delitDAO = new DelitDAO();
$lesDelits = $delitDAO->getById($id_delit);
foreach ($lesDelits as $unDelit) {
	$nature[$unDelit->getIdDelit()] = $unDelit->getNature();
}


require_once('../Modele/delitByInfractionDAO.class.php');
$delitByInfractionDAO = new DelitByInfractionDAO();

// gestion des zones non modifiables en mode "modif"
$valeurs['id_inf'] = null;
if ($modif)	{
	$valeurs['id_inf'] 		= $id;
	$unDelitByInfraction 	= $delitByInfractionDAO->getLesDelitByIdInf($valeurs['nature']);
}
if ($editNature) {
	$valeurs['id_inf'] = (isset($_POST['id_inf'])?trim($_POST['id_inf']):$valeurs['id_inf']);
}

$retour = false;


$titre .= (($op=='a')?'Nouveau délit: ':(($op=='m')?"Edition d'un délit: ":null));


if (isset($_POST['valider'])) {
	if (!isset($valeurs['id_inf']) or strlen(trim($valeurs['id_inf']))==0) 			{ $erreurs['id_inf'] = "Veuillez saisir un id !"; }
	

 	$nbErreurs = 0;
 	foreach ($erreurs as $erreur){
 		if ($erreur != "") $nbErreurs++;
 	}
 	if ($nbErreurs == 0){
		$unDelit		= $delitDAO->getById($valeurs['id_inf']);
		$unDelitByInfraction= new DelitByInfraction($valeurs['id_inf']);
		$retour = true;
		if ($op=="a")	{
			$delitDAO->insert($unDelitByInfraction);
		}	
		else {			
			$delitByInfractionDAO->update($unDelitByInfraction);
		}
	}
}
else if (isset($_POST['annuler']))	{
	$retour = true;
}
else if ($suppr) {
// suppression
	$delitByInfractionDAO->deleteByIdInfByIdDelit($valeurs['id_inf']);
	$retour = true;
}
else if ($modif)	{
	require_once('../Modele/delitByInfractionDAO.php');
	$delitByInfractionDAO = new delitByInfractionDAO();   
	$unDelitByInfraction = $delitByInfractionDAO->getLesDelitByIdInf($num,$id);
	if ($undelit === null) { 
        $valeurs['nature'] = $undelit->getNature();
        $valeurs['montant'] = $undelit->getMontant();
    }
}


if ($retour)
{
	header("location: adminInfraction.php");
}	

require_once("../vue/editDelit.view.php");
?>