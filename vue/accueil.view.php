<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../vue/style/style.css">
    <title>Accueil</title>
</head>
<body>

<!-- <section><?=$message?></section> -->
<section>
    <label></label>
    <h1>Liste des infractions</h1>
</section>
<section>
    <!-- Afficher les infractions pour un permis donné -->
<table>
  <thead>
    <tr>
      <th>N° infraction</th>
      <th>Date</th>
      <th>Véhicule</th>
      <th>Conducteur</th>
      <th>Montant</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    
    <?php foreach ($infractionsPermis as $infraction): ?>
      
     
      <tr>
        <td><?php echo $infraction->getIdInf(); ?></td>
        <td><?php echo $infraction->getDateInf(); ?></td>
        <td><?php echo $infraction->getNumImmat(); ?></td>
        <td><?php echo $infraction->getNoPermis(); ?></td>
        <td><?php echo $infraction->getNoPermis(); ?></td>
      	<td><?php echo '<a href="../controleur/delitInfraction.php?op=d&id='
        .urlencode($infraction->getIdInf()) .'">
        <img src="../vue/style/visu.png"></a>' ?> </td>;

      </tr>

      <?php endforeach ?>
     

      

  
  </tbody>
  <tfoot>
        <tr><td colspan="7"></td></tr>
        <tr>
            <td></td>
            <td colspan="7" style="text-align:right" ><a href="../controleur/login.php" class="ajout">Déconnexion</a></td>
        </tr>
    <!-- Ajouter des totaux pour le montant ici si nécessaire -->
  </tfoot>
</table>
</section>
</body>
</html>