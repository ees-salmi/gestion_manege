<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: ../vue/login.php');
    exit();
}

if (isset($_POST['modifier'])) {
    // connexion à la base de données
    include '../myparam.inc.php';

 // Use the variables defined in config.php
    $db_host = MYHOST;
    $db_username = MYUSER;
    $db_password = MYPASS;
    $db_name = MYBASE;
 
    $db = mysqli_connect($db_host, $db_username, $db_password, $db_name) or die('could not connect to database');

    // on applique les deux fonctions mysqli_real_escape_string et htmlspecialchars
    // pour éliminer toute attaque de type injection SQL et XSS
    $nom = mysqli_real_escape_string($db, htmlspecialchars($_POST['nom']));
    $prenom = mysqli_real_escape_string($db, htmlspecialchars($_POST['prenom']));
    $date_naissance = mysqli_real_escape_string($db, htmlspecialchars($_POST['date_naissance']));

    $username = $_SESSION['username'];

    $requete = "UPDATE personnel SET nom_personnel = '" . $nom . "', prenom_personnel = '" . $prenom . "', date_naissance = '" . $date_naissance . "' WHERE nom_personnel = '" . $username . "'";
    $exec_requete = mysqli_query($db, $requete);

    if ($exec_requete) {
        $_SESSION['username'] = $nom;
        header('Location: ../vue/dashboard_directeur.php?success=1');
    } else {
        header('Location: ../vue/modifier_profil.php?erreur=1');
    }

    mysqli_close($db); // fermer la connexion
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Modifier Profil</title>
    <link rel="stylesheet" href="modifier_profil.css">
</head>

<body>
    <div class="container">
        <h2>Modifier Profil</h2>
        <form action="" method="post">
            <div class="form-group">
                <label for="nom">Nom:</label>
                <input type="text" class="form-control" id="nom" name="nom" required autocomplete="off">
            </div>
            <div class="form-group">
                <label for="prenom">Prénom:</label>
                <input type="text" class="form-control" id="prenom" name="prenom" required autocomplete="off">
            </div>
            <div class="form-group">
                <label for="date_naissance">Date de Naissance:</label>
                <input type="date" class="form-control" id="date_naissance" name="date_naissance" required>
            </div>
            <button type="submit" name="modifier" class="btn">Modifier</button>
            <button onclick="goBack()" class="btn">Retour</button>
        </form>
    </div>
    <script>
        function goBack() {
            window.history.go(-1);
        }
    </script>
</body>

</html>