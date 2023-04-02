<?php
// Connexion à la base de données
$db_username = 'root';
$db_password = '';
$db_name = 'bdd_manege';
$db_host = 'localhost';
$db = mysqli_connect($db_host, $db_username, $db_password, $db_name)
    or die('could not connect to database');
// Vérifiez si les paramètres de recherche sont définis
if (isset($_GET['categorie'])) {
    $categorie = mysqli_real_escape_string($db, $_GET['categorie']);
} else {
    $categorie = '';
}

if (isset($_GET['keywords'])) {
    $keywords = mysqli_real_escape_string($db, $_GET['keywords']);
} else {
    $keywords = '';
}


// Construire la requête en fonction des paramètres de recherche
$manege_query = "SELECT id_manege, nom_manege, description, taille_min_client, id_atelier, id_zone, id_famille FROM manege WHERE nom_manege LIKE '%$keywords%'";
$boutique_query = "SELECT id_boutique, chiffre_affaire,nb_clients_quotid, type_boutique, responsable_id, id_zone FROM boutique WHERE type_boutique LIKE '%$keywords%'";

if ($categorie == 'manege' || $categorie == '') {
    $result = mysqli_query($db, $manege_query);
    if (mysqli_num_rows($result) > 0) {
        echo '<h2>Les Manèges :</h2> ';
        while ($row = mysqli_fetch_assoc($result)) {
            echo "
        <div id='search_result'>   
            <a href='#' onclick='resultat_click_manege(\"" . $row['id_manege'] . "\", \"" . $row['nom_manege'] . "\", \"" . $row['description'] . "\", \"" . $row['taille_min_client'] . "\", \"" . $row['id_atelier'] . "\", \"" . $row['id_zone'] . "\", \"" . $row['id_famille'] . "\");'>" . $row['nom_manege'] . "</a>
        </div>";
        }
    } else {
        echo "Aucun résultat trouvé.";
    }


} elseif ($categorie == 'boutique' || $categorie == '') {
    $result = mysqli_query($db, $boutique_query);
    if (mysqli_num_rows($result) > 0) {
        echo '<h2>Les Boutiques :</h2> ';
        while ($row = mysqli_fetch_assoc($result)) {
            echo "
        <div id='search_result'>   
       <a href='#' onclick='resultat_click_boutique(\"" . $row['id_boutique'] . "\", \"" . $row['type_boutique'] . "\", \"" . $row['chiffre_affaire'] . "\", \"" . $row['nb_clients_quotid'] . "\", \"" . $row['responsable_id'] . "\", \"" . $row['id_zone'] . "\");'>" . $row['type_boutique'] . "</a>
            </div>";
        }
    } else {
        echo "Aucun résultat trouvé.";
    }
} else {
    die('Error: missing parameters');
}


mysqli_close($db);
?>