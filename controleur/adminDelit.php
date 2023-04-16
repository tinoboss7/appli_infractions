<?php

$op 	= (isset($_GET['op'])?$_GET['op']:null);
$ajout 	= ($op == 'a');
$supprI = ($op == 's/I');
$supprD = ($op == 's/D');
$modif 	= ($op == 'm');
$detail = ($op == 'd');
$idInf	= (isset($_GET['idInf'])?$_GET['idInf']:null);
$idDelit	= (isset($_GET['idDelit'])?$_GET['idDelit']:null);
$montant = (isset($_GET['montant']) ? $_GET['montant'] : null);
$editIdInf= $ajout;

// accès à la page uniquement si un numéro de salle et statut opération sont passés en paramètre
if ($idInf=null) {
	header("location: utilisateurInfraction.php");
} 


require_once('../Modele/infractionDAO.class.php');
$infractionDAO = new Infraction();
$uneInfraction = $infractionDAO->getByIdInf($idInf);
$infractionDetail = $infractionDAO->getDetail($idInf);
$montantInfr=$infractionDAO->getTotalMontantInfByTd($idInf);

require_once('../Modele/delitDAO.class.php');
$delitDAO = new DelitDAO();
$unDelit = $delitDAO->getById($id);
$titre = $id.' '.$unDelit->getNature();

require_once('../Modele/delitByInfractionDAO.class.php');
$delitByInfractionDAO = new DelitByInfractionDAO();
$lesDelitsByInctraction = $delitByInfractionDAO->getLesDelitByIdInf($id);

// gestion des zones non modifiables en mode "modif"
$valeurs['id_delit'] = null;
if ($modif)	{
	$valeurs['id_delit'] = $num;
	$unDélit = $delitDAO->getById($valeurs['id']);
}
if ($editId) {
	$valeurs['id_delit'] = (isset($_POST['id_delit'])?trim($_POST['id_delit']):$valeurs['id_delit']);
}


$titre = (($ajout)?'Nouveau délit ':(($modif)?"Délit - édition des informations":null));

$erreurs = ['id_delit'=>"", 'nature'=>'', 'montant'=>""];
$valeurs['nature'] = (isset($_POST['nature'])?trim($_POST['nature']):null);
$valeurs['montant'] = (isset($_POST['montant'])?trim($_POST['montant']):null);

$retour = false;
	
if (isset($_POST['valider'])) {
	if (!isset($valeurs['id_delit']) or strlen($valeurs['id_delit'])==0) 	{ $erreurs['id_delit']	= 'saisie obligatoire du numéro';	}
	else if ($editId and $delitDAO->existe($valeurs['id_delit'])) 	{ $erreurs['id_delit'] 	= 'Numéro de délit déjà existant.';	}
	if (!isset($valeurs['nature']) or strlen($valeurs['nature'])==0 or !in_array($valeurs['montant'],$montant,true)) { 
		$erreurs['nature'] = 'Entrer la nature '; 
	}
	if (!isset($valeurs['montant']) or strlen($valeurs['montant'])==0 or !in_array($valeurs['montant'],$montant,true)) { 
		$erreurs['montant'] = 'Entrer le montant'; 
	}


 	$nbErreurs = 0;
 	foreach ($erreurs as $erreur){
 		if ($erreur != "") $nbErreurs++;
 	}
 	if ($nbErreurs == 0){
		$unDelit = new delit($valeurs['id_delit'],$valeurs['nature'], $valeurs['montant']);
		$retour = true;
		if ($ajout)	{
			$delitDAO->insert($unDelit);
		}	
		else {			
			$delitDAO->update($unDelit);
		}
	}
}
else if (isset($_POST['annuler']))	{
	$retour = true;
}
else if ($suppr) {
// suppression
	$delitDAO->delete($num);
	$retour = true;
}
else if ($modif)	{
	$unDelit = $delitDAO->getById($id_delit);
	$valeurs['num']		= $unDelit->getIdDelit();
	$valeurs['nature'] = $unDelit->getNature();		
	$valeurs['id_delit'] 	= $unDelit->getMontant();		
}


if ($retour)
{
	header("location: infraction.php");
}	


/*foreach ($lesDelitByInfraction as $unDelitByInfraction) {
    $ch = '';
    $ch .= '<td>' . $unDelitByInfraction["id_delit"] . '</td>';
    $ch .= '<td>' . $unDelitByInfraction["nature"] . '</td>';
    $ch .= '<td>' . $unDelitByInfraction["montant"] ."€". '</td>'; 

    
	$ch .='<td onclick="confirmerAvantEffacer()" ><a href="effacerDelit.php?op=sD&id='   
	.urlencode($uneInfraction->getId()).'&idd='.$unDelitByInfraction["id_delit"] 
	.'" ><img src="../vue/style/corbeille.png"></a></td>';
    

    $lignes[] = "<tr>$ch</tr>";
}*/

require_once("../vue/editInfraction.view.php");
?>