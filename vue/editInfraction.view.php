<html>
<head>
    <meta charset="utf-8">
    <title><?php echo $titre ?></title>
    <link rel="stylesheet" href="../vue/style/style.css">
</head>
<body>
<?php require_once('../vue/header.php') ?>
<section>
    <label></label>
    <h1><?php echo $titre ?></h1>
</section>

<form name="add" action="" method="post">
<section>
    <label for="num">N° infraction :</label>
    <div>   
        <?php
        if ($editNum) {
        ?>
            <input id="num" name="num" type="text" size="10" maxlength="10" value=" <?= htmlentities($valeurs['num']) ?>" />
            <br/>
            <span   class="erreur"><?= $erreurs['num'] ?></span>'
        <?php
            } else {
            echo  $valeurs['num'];
        }
        ?>
    </div>
</section>
<section>
        <label for="date_inf">Date d'infraction :</label>
        <div>
            <input id="date_inf" name="date_inf" type="date" value="<?= htmlentities($valeurs['date_inf']) ?>" />
            <br/>
            <span class="erreur"><?= $erreurs['date_inf'] ?></span>
        </div>
</section>
<section>
        <label for="no_immat">Numéro d'immatriculation :</label>
        <div>
            <input id="no_immat" name="no_immat" type="text" value="<?= $valeurs['no_immat'] ?>" />
            <br/>
            <span class="erreur"><?= $erreurs['no_immat'] ?></span>
        </div>
</section>
<section>
        <label for="no_permis">Numéro de permis :</label>
        <div>
            <input id="no_permis" name="no_permis" type="text" value="<?= $valeurs['no_permis'] ?>" />
            <br/>
            <span class="erreur"><?= $erreurs['no_permis'] ?></span>
        </div>
</section>


<section>
        <label>&nbsp;</label>
        <div>
            <input type="submit" id="valider" name="valider" value="Valider" />
            &emsp;
            <input type="submit" id="annuler" name="annuler" value="Annuler" />
        </div>
</section>

</form>

</body>
</html>
