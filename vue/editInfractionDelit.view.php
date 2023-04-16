<html>
<head>
<meta charset="utf-8">
<title>Liste des délits des infractions</title>
<link rel="stylesheet" href="../vue/style/style.css">
</head>
<body>
<?php require_once('../vue/header.php'); ?>
<section>
    <label></label>
    <h1>Détail de l'infraction <?=$titre ?></h1>
</section>

<section>
    <label></label>
    <table border="1" class="table_infraction_delit" >
    <tr>
        <th>Numéro</th>
        <th>Nature</th>
        <th>Montant</th>
        <th></th>
        <th></th>
    </tr>

    <?php
    foreach($lignes as $ligne) {
        echo $ligne;
    }
    ?>

    <tr><td colspan="5"></td></tr>
    <tr>
        <td style="text-align:right" ><a href="../controleur/utilisateurInfraction.php?" class='retour' >Retour</a></td>
        <td id="montantTotal"> Montant  Total : </td>
    </tr>
    </table>
</section>

</body>
</html>