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

if($detail){
    $lignes = [];

    foreach($lesDelitsByInctraction as $unDelitByInfraction){
        $ch = '';
        $ch .= '<td>' . $unDelitByInfraction["id_delit"] . '</td>';
        $ch .= '<td>' . $unDelitByInfraction["nature"] . '</td>';
        $ch .= '<td>' . $unDelitByInfraction["montant"] ."€". '</td>';

        $lignes[] = "<tr>$ch</tr>";
    }
}

require_once("../vue/delitInfraction.view.php");
?>