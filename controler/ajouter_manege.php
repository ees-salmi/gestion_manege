<?php
// Connexion à la base de données
$pdo = new PDO('mysql:host=localhost;dbname=nom_de_la_base_de_données', 'nom_utilisateur', 'mot_de_passe');

// Récupération des données du formulaire
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Receive the data from the form using $_POST
    $id_manege = $_POST['id_manege'];
    $nom_manege = $_POST['nom_manege'];
    $description = $_POST['description'];
    $taille_min_client = $_POST['taille_min_client'];
    $id_atelier = $_POST['id_atelier'];
    $id_zone = $_POST['id_zone'];
    $id_famille = $_POST['id_famille'];
    
    // Prepare the SQL statement with placeholders
    $sql = "INSERT INTO `manege` (`id_manege`, `nom_manege`, `description`, `taille_min_client`, `id_atelier`, `id_zone`, `id_famille`) VALUES (?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_manege, $nom_manege, $description, $taille_min_client, $id_atelier, $id_zone, $id_famille]);
    
// Message de confirmation
echo "Le manège a été ajouté avec succès !";






?>