<html>
<head>
<meta charset="utf-8">
<title>Liste des infractions</title>
<link rel="stylesheet" href="../vue/style/style.css">
</head>
<body>
<?php require_once('../vue/header.php'); ?>

<section>
    <label></label>
    <h1>Liste des infractions</h1>
</section>

<section>
    <table border="1" class='table_infraction'>
        <tr>
            <th>N° infraction</th>
            <th>Date</th>
            <th>Véhicule</th>
            <th>Conducteur</th>
            <th>Montant</th>
            <th>Action</th>
            <th>Action</th>
        </tr>
    
        <?php
        foreach($lignes as $ligne) {
            echo $ligne; // tableau de lignes à créer dans /controleur/infraction.php
        }
        ?>

        <tr><td colspan="7"><?php $montant ?></td></tr>
        <tr>
            <td></td>
            <td colspan="7" style="text-align:right" ><a href="../controleur/editInfraction.php?op=a" class="ajout">Ajouter un infraction</a></td>
        </tr>
    </table>
</section>

</body>
</html>