<?php
// Connexion à la base de données
$db_username = 'root';
$db_password = '';
$db_name = 'bdd_manege';
$db_host = 'localhost';
$conn = mysqli_connect($db_host, $db_username, $db_password,$db_name)
or die('could not connect to database');

?>