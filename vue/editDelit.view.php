<html>
<head>
<meta charset="utf-8">
<title><?php echo $titre ?></title>
<link rel="stylesheet" href="../vue/style/style.css">
</head>
<body>

<section>
    <label></label>
    <h1><?php echo $titre ?></h1>   
</section>

<form name="add" action="" method="post">
<section>
    <label  for="id">Delit :</label>
    <div>
    <label for="nature">Nature des délits :</label>
    <select id="nature" name="nature[]" multiple>
        <option value="1">Excès de vitesse</option>
        <option value="2">Outrage à agent</option>
        <option value="3">Feu rouge grillé</option>
        <option value="4">Conduite en état d'ivresse</option>
        <option value="5">Délit de fuite</option>
        <option value="6">Refus de priorité</option>
    </select>
    <br />
    <span class="erreur"><?= $erreurs['nature'] ?></span>
    </div>
</section>
<section>
    <label  for="montant">Montant :</label>
    <div>
	    <input	id="montant" name="trf"	type="texte" size="30" maxlength="30" value="<?= htmlentities($valeurs['montant']) ?>" />
	    <br/>
        <span   class="erreur"><?= $erreurs['montant'] ?></span>
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