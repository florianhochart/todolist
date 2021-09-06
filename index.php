<?php
require('config/bdd.php');
$erreur = '';

// AJOUTER UNE TACHE
if((isset($_POST['input_libelle'])) && (isset($_POST['input_etiquette']))){
    $stmt = $db->prepare("INSERT INTO tasks (libelle, etiquette) VALUES (:libelle, :etiquette)");
    $stmt->bindParam(':libelle', $libelle);
    $stmt->bindParam(':etiquette', $etiquette);
    $libelle = $_POST['input_libelle'];
    $etiquette = $_POST['input_etiquette'];
    $stmt->execute();
}

//SUPPRIMER UNE TACHE
if(isset($_GET['id'])){
    $stmt = $db->prepare("DELETE FROM tasks WHERE id=:id");
    $stmt->bindParam(':id', $id);
    $id = $_GET['id'];
    $stmt->execute();
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>TodoList</title>
</head>
<body>
    <center><h1 style="font-family:Arial-Black;">TODOLIST</h1></center>
    <?php echo $erreur ?>
<form method="post" action="index.php" style="margin-top: 30px;margin-bottom: 30px;">
        <input type="text" name="input_libelle" placeholder="Faire du sport.." style="width: 40%;"/>
        <select name="input_etiquette">
            <option value="blue" style="color: blue;">BLEU</option>
            <option value="green" style="color: green;">VERT</option>
            <option value="red" style="color: red;">ROUGE</option>
            <option value="yellow" style="color: yellow;">JAUNE</option>
            <option value="brown" style="color: brown;">MARRON</option>
        </select>
        <button type="submit">Créer</button>
</form>

<table class="table">
  <thead>
    <tr>
      <th scope="col">Libellé</th>
      <th scope="col">Etiquette</th>
      <th scope="col">Actions</th>
    </tr>
  </thead>
  <tbody>
  <?php
    $reponse = $db->query('SELECT * FROM tasks ORDER BY etiquette ASC');
    while ($taches = $reponse->fetch()) { 
        ?>
        <tr>
        <td><?php echo '<div class=square style=background-color:'.$taches['etiquette'].';width:25px;height:25px;>'; ?></div></td>
            <td><?php echo $taches['libelle'] ?></td>
            <td><a class="suppr" href="index.php?id=<?php echo $taches['id'] ?>"> Supprimer</a></td>
        </tr>
        <?php
    }
 
 
    ?>
  </tbody>
</table>
</body>
</html>