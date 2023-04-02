<?php
// Connexion à la base de données
$db_username = 'root';
$db_password = '';
$db_name = 'bdd_manege';
$db_host = 'localhost';
$db = mysqli_connect($db_host, $db_username, $db_password, $db_name)
    or die('could not connect to database');
// Check if the search parameters are set
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


// Construct the query based on the search parameters
$manege_query = "SELECT id_manege, nom_manege, description, id_atelier, id_zone FROM manege WHERE nom_manege LIKE '%$keywords%'";
$boutique_query = "SELECT id_boutique, chiffre_affaire, type_boutique, responsable_id, id_zone FROM boutique WHERE type_boutique LIKE '%$keywords%'";

if ($categorie == 'manege' || $categorie == '') {
    $result = mysqli_query($db, $manege_query);
    if (mysqli_num_rows($result) > 0) {
        echo "
    <div id='search_result'>
    <table>
          <tr>
            <th>Nom</th>
            <th>Description</th>
            <th>id_Atelier</th>
            <th>id_Zone</th>
          </tr>
          </div>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "
        <div id='search_result'>
        <tr>
            <td>" . $row['nom_manege'] . "</td>
            <td>" . $row['description'] . "</td>
            <td>" . $row['id_atelier'] . "</td>
            <td>" . $row['id_zone'] . "</td>
          </tr> </div>";
        }
        echo "</table>";
    } else {
        echo "Aucun résultat trouvé.";
    }


} elseif ($categorie == 'boutique' || $categorie == '') {
    $result = mysqli_query($db, $boutique_query);
    if (mysqli_num_rows($result) > 0) {
        echo "
    <div id='search_result'>
    <table>
          <tr>
            <th>id Boutique</th>
            <th>Chiffre d'affaire</th>
            <th>Type Boutique</th>
            <th>responsable_id</th>
            <th>id_Zone</th>
          </tr>
          </div>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "
        <div id='search_result'>
        <tr>
            <td>" . $row['id_boutique'] . "</td>
            <td>" . $row['chiffre_affaire'] . "</td>
            <td>" . $row['type_boutique'] . "</td>
            <td>" . $row['responsable_id'] . "</td>
            <td>" . $row['id_zone'] . "</td>
          </tr> </div>";
        }
        echo "</table>";
    } else {
        echo "Aucun résultat trouvé.";
    }


} else {
    die('Error: missing parameters');
}

// Display the search results


mysqli_close($db);
?>