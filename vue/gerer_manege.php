<?php
// Connexion à la base de données
$db_username = 'root';
$db_password = '';
$db_name = 'bdd_manege';
$db_host = 'localhost';
$conn = mysqli_connect($db_host, $db_username, $db_password,$db_name)
or die('could not connect to database');
// Récupération des données du formulaire
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // preparer la requete pour eviter le SQL injection
    $id_manege   = mysqli_real_escape_string($conn, $_POST['id_manege']);
    $nom_manege  = mysqli_real_escape_string($conn, $_POST['nom_manege']);
    $description = mysqli_real_escape_string($conn,  $_POST['description']);
    $taille_min_client = mysqli_real_escape_string($conn, $_POST['taille_min_client']);
    $id_atelier = mysqli_real_escape_string($conn, $_POST['id_atelier']);
    $id_zone = mysqli_real_escape_string($conn, $_POST['id_zone']);
    $id_famille = mysqli_real_escape_string($conn, $_POST['id_famille']);
    
    // Prepare the SQL statement with placeholders
                                            
    $sql = "INSERT INTO `manege`(`id_manege`, `nom_manege`, `description`, `taille_min_client`, `id_atelier`, `id_zone`, `id_famille`)
     VALUES ($id_manege, '$nom_manege','$description',$taille_min_client,$id_atelier,$id_zone,'$id_famille')";
    if (mysqli_query($conn, $sql)) {
        echo "New record created successfully";
      } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }
    }   
// Message de confirmation
?>

<!DOCTYPE html>
<html>
<head>
    <title>Modifier Profil</title>
    <link rel="stylesheet" href="../controler/modifier_profil.css">
    <style>

.card {
  background-color: #fff;
  border-radius: 10px;
  box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.15);
  padding: 20px;
  margin: 20px;
}

table {
  border-collapse: collapse;
  width: 100%;
}

th, td {
  text-align: left;
  padding: 8px;
}

th {
  background-color: #f2f2f2;
}

tr:nth-child(even) {
  background-color: #f2f2f2;
}

button {
  background-color: #e74c3c;
  border: none;
  color: white;
  padding: 8px 16px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 14px;
  border-radius: 4px;
  cursor: pointer;
}

button:hover {
  background-color: #c0392b;
}

button:active {
  background-color: #f44336;
}


    </style>
</head>
<body>
    <?PHP $sql = "SELECT * FROM manege";
    $result = mysqli_query($conn, $sql);
    ?>
        <table>
        <thead>
            <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Description</th>
            <th>Taille min client</th>
            <th>Atelier</th>
            <th>Zone</th>
            <th>Famille</th>
            <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?PHP 
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['id_manege'] . "</td>";
            echo "<td><a href='../controler/update.php?id_manege=" . $row['id_manege'] . "'>" . $row['nom_manege'] . "</a></td>";
            echo "<td>" . $row['description'] . "</td>";
            echo "<td>" . $row['taille_min_client'] . "</td>";
            echo "<td>" . $row['id_atelier'] . "</td>";
            echo "<td>" . $row['id_zone'] . "</td>";
            echo "<td>" . $row['id_famille'] . "</td>";
            echo "<td><form method='POST' action='../controler/delete.php'>
                <input type='hidden' name='id_manege' value='" . $row['id_manege'] . "'>
                <button type='submit'>Delete</button>
                </form></td>";
            echo "</tr>";
                }
                ?>

    <div class="container">
        <h2>ajouter manege</h2>
        <form action="gerer_manege.php" method="post">
            <div class="form-group">
                <label for="id">identifent de manegre</label>
                <input type="text" class="form-control" id="id" name="id_manege" required>
            </div>
            <div class="form-group">
                <label for="nom">Nom manege:</label>
                <input type="text" class="form-control" id="nom" name="nom_manege" required>
            </div>
            <div class="form-group">
                <label for="prenom">description:</label>
                <input type="text" class="form-control" id="prenom" name="description" required>
            </div>
            <div class="form-group">
                <label for="date_naissance">taille min des client:</label>
                <input type="number" class="form-control" id="date_naissance" name="taille_min_client" required>
            </div>
            <div class="form-group">
                <label for="date_naissance">Numero d'atelier:</label>
                <input type="number" class="form-control" id="date_naissance" name="id_atelier" required>
            </div>
            <div class="form-group">
                <label for="date_naissance">Numero de zone:</label>
                <input type="number" class="form-control" id="date_naissance" name="id_zone" required>
            </div>
            <div class="form-group">
            <label for="id_famille">selectionner la famille:</label>
            <?php
            $sql = "SELECT id_famille, nom_famille FROM famille_manege";

            $result = mysqli_query($conn, $sql);
            echo '<select class="form-control" id="id_famille" name="id_famille" required>';
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<option value="' . $row['id_famille'] . '">' . $row['nom_famille'] . '</option>';
                }
                echo '</select>';
            ?>
            </div>
            <button type="submit" name="modifier" class="btn">ajouter</button>
        </form>
    </div>
</body>
</html>