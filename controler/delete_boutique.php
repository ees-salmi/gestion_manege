<?php
// Connexion à la base de données
$db_username = 'root';
$db_password = '';
$db_name = 'bdd_manege';
$db_host = 'localhost';
$db = mysqli_connect($db_host, $db_username, $db_password, $db_name)
    or die('could not connect to database');

if (isset($_POST["id"])) {
    $id = $_POST["id"];

    // Delete boutique from the database
    $sql = "DELETE FROM boutiques WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    if ($stmt) {
        echo '<script>alert("La boutique a été ajoutée avec succès");</script>';

        echo ' <script>
            window.history.go(-1);
    </script>';
    } else {
        echo '<script>alert("Error supprimer boutique.");</script>';

        echo ' <script>
            window.history.go(-1);
    </script>';
    }
}
?>