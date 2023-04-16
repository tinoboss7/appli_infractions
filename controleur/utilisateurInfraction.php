<?php
require_once('../Modele/infractionDAO.class.php');
require_once('../Modele/delitDAO.class.php');

session_start();
$infractionDAO = new InfractionDAO();
$delitDAO = new DelitDAO();

$lesInfractions = $infractionDAO->getNomPermis($_SESSION['login']);
$lignes	= [];
foreach($lesInfractions as $uneInraction)
{
	$montant = 0;
	$dataInf = $delitDAO->getByNumInf($uneInfraction->getIdInf());
	foreach($dataInf as $delit){$montant += $delit->getMontant();}

	$ch = '';

	$ch .='<td>' .$uneInraction->getIdInf() . '</td>';
	$ch .='<td>' .$uneInraction->getDateInf() . '</td>';
	$ch .='<td>' .$uneInfraction->getNumImmat() . '</td>';
    $ch .='<td>' .$uneInfraction->getNoPermis() . '</td>';
	

	$ch .='<td><a href="delitInfraction.php?op=d&id=' .urlencode($uneInfraction->getIdInf()) .'&montant='.$montant.
	'"><img src="../vue/style/visu.png"></a></td>';
	$lignes[] = "<tr>$ch</tr>";
}
unset($lesInfractions);

require_once('../vue/accueil.view.php');

