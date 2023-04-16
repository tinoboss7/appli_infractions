<?php
require_once('../Modele/infractionDAO.php');

$infractionDAO = new InfractionDAO();

$lesInfractions = $infractionDAO->getAll();

$lignes	= [];
foreach($lesInfractions as $uneInfraction)
{
	$ch = '';

	$ch .='<td>' .$uneInfraction->getId() . '</td>';
	$ch .='<td>' .$uneInfraction->getImmatricul() . '</td>';
	$ch .='<td>' .$uneInfraction->getDateinfract() . '</td>';
	$ch .='<td>' .$uneInfraction->getNopermis() . '</td>';
	$ch .='<td><a href="../controleur/editInfraction.php?op=m&num=' .urlencode($uneInfraction->getIdInf()) .'"><img src="../vue/style/modification.png"></a></td>';
	$ch .='<td><a href="../controleur/editInfraction.php?op=s&num=' .urlencode($uneInfraction->getIdInf()) .'" ><img src="../vue/style/corbeille.png"></a></td>';
	$ch .='<td><a href="adminDelit.php?op=d&id='.urlencode($uneInfraction->getId()) .'"><img src="../vue/style/visu.png"></a></td>';
	$lignes[] = "<tr>$ch</tr>";
}

unset($lesInfractions);

require_once('../vue/infraction.view.php');
?>