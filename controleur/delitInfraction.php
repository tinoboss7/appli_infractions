<?php

$op 	= (isset($_GET['op'])?$_GET['op']:null);
$deta 	= ($op == 'd');
$editNum= $ajout;
$id = (isset($_GET['id']) ? $_GET['id'] : null);

if ($num==null) {
	header("location: infraction.php");
} 

require_once('../Modele/infractionDAO.class.php');
$infractionDAO = new InfractionDAO();
$uneInfraction = $infractionDAO->getById($id);

require_once('../Modele/delitByInfractionDAO.class.php');
$delitByInfractionDAO = new delitByInfractionDAO();
$lesDelitsByInfraction = $delitByInfractionDAO->getByidInf($id);
$lignes	= [];
foreach($lesDelitsByInfraction as $unDelitByInfraction)
{	
    
    $ch = '';
    $ch .= '<td>' .$unDelitByInfraction->getIdDelit() .'</td>';
    $ch .= '<td>' .$unDelitByInfraction->getNature() .'</td>';
	$ch .= '<td>' .$unDelitByInfraction->getMontant() .'</td>';

	$ch .='<td><a href="editInfractionDelit.php?op=m&num=' .urlencode($id) .'&id=' .urlencode($unDelitByInfraction->getIdDelit()) .'" ><img src="../vue/style/modification.png"></a></td>';
    $ch .= '<td><a href="editInfractionDelit.php?op=s&num=' .urlencode($id) .'&id=' .urlencode($unDelitByInfraction->getIdDelit()) .'" ><img src="../vue/style/corbeille.png"></a></td>';
 
	$lignes[] = "<tr>$ch</tr>";
}

require_once('../vue/infraction.view.php');