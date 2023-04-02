<?php
// Connexion à la base de données
$db_username = 'root';
$db_password = '';
$db_name = 'bdd_manege';
$db_host = 'localhost';
$db = mysqli_connect($db_host, $db_username, $db_password, $db_name)
    or die('could not connect to database');

// Récupérer les données du formulaire
$type = $_POST["type"];
$responsable = $_POST["responsable"];
$chiffre_affaire = $_POST["chiffre_affaire"];
$nombre_client_quotid = $_POST["nombre_client_quotid"];
$id_zone = $_POST["id_zone"];

// Insérer des données dans la base de données
$sql = "INSERT INTO boutique (id_boutique, chiffre_affaire, nb_clients_quotid, type_boutique, responsable_id, id_zone) 
        VALUES (NULL, $chiffre_affaire, $nombre_client_quotid, '$type', '$responsable', $id_zone)";
if ($db->query($sql) === TRUE) {
    echo '<script>alert("La boutique a été ajoutée avec succès");</script>';

    echo ' <script>
            window.history.go(-1);
    </script>';
} else {
    echo "Error: " . $sql . "<br>" . $db->error;
}

// Fermer la connexion à la base de données
$db->close();
?>