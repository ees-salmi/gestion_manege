<?php
// Connexion à la base de données
$db_username = 'root';
$db_password = '';
$db_name = 'bdd_manege';
$db_host = 'localhost';
$db = mysqli_connect($db_host, $db_username, $db_password, $db_name)
    or die('could not connect to database');

// Récupérer les données du formulaire
$name = $_POST["name"];
$description = $_POST["description"];
$taille_min_client = $_POST["Taille_min_Client"];
$id_atelier = $_POST["id_Atelier"];
$id_zone = $_POST["id_zone"];
$id_famille = $_POST["id_famille"];

// Insérer des données dans la base de données
$sql = "INSERT INTO manege (id_manege, nom_manege, description, taille_min_client, id_atelier, id_zone, id_famille) 
        VALUES (NULL, '$name', '$description', $taille_min_client, $id_atelier, $id_zone, '$id_famille')";
if ($db->query($sql) === TRUE) {
    echo '<script>alert("La manège a été ajoutée avec succès");</script>';

    echo ' <script>
            window.history.go(-1);
    </script>';
} else {
    echo "Error: " . $sql . "<br>" . $db->error;
}
// Fermer la connexion à la base de données
$db->close();
?>