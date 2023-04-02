<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="Welcome_style.css">
    <title>Dashboard - Technicien</title>
</head>

<body>
    <?php
    session_start();
    if (!isset($_SESSION['username'])) {
        header('Location: login.php');
        exit();
    }

    // Check the user's role from the database and redirect to the appropriate page
    $db_username = 'root';
    $db_password = '';
    $db_name = 'bdd_manege';
    $db_host = 'localhost';
    $db = mysqli_connect($db_host, $db_username, $db_password, $db_name)
        or die('could not connect to database');

    $username = mysqli_real_escape_string($db, $_SESSION['username']);

    // Get the user's role from the database
    $role_query = "SELECT type_personnel FROM personnel WHERE nom_personnel = '$username'";
    $role_result = mysqli_query($db, $role_query);
    $role_row = mysqli_fetch_assoc($role_result);
    $role = $role_row['type_personnel'];

    // Get the director's information from the database
    $Technicien_query = "SELECT prenom_personnel, nom_personnel, date_naissance FROM personnel WHERE nom_personnel = '$username'";
    $Technicien_result = mysqli_query($db, $Technicien_query);
    $Technicien_row = mysqli_fetch_assoc($Technicien_result);
    $prenom = $Technicien_row['prenom_personnel'];
    $nom_famille = $Technicien_row['nom_personnel'];
    $date_naissance = $Technicien_row['date_naissance'];

    mysqli_close($db);
    ?>
    <div class="container">
        <div class="header">
            <h1>Dashboard Technicien</h1>
            <a href="../controler/modifier_profil.php">Modifier le profil</a>
            <a href="../controler/logout.php">Déconnexion</a>
        </div>
        <div id="result-container">
            <h2 id='search_title'>Recherche : </h2>
            <label><b>Catégorie</b></label>
            <select name="categorie" id="categorie">
                <option value="">Toutes les catégories</option>
                <option value="manege">Manèges</option>
                <option value="boutique">Boutiques</option>
            </select>
            <label><b>Mots-clés</b></label>
            <input type="text" placeholder="Entrer des mots-clés" name="keywords" id="keywords">
            <input type="submit" id='submit' onclick="getDetails()" value='Rechercher'></input>
        </div>
        <div class="content">
            <div class="card">
                <h1>Bonjour, Technicien
                    <?php echo $username; ?>!
                </h1>
                <h2>Informations personnelles</h2>
                <p>Prénom:
                    <?php echo $prenom; ?>
                </p>
                <p>Nom:
                    <?php echo $nom_famille; ?>
                </p>
                <p>Date de Naissance:
                    <?php echo $date_naissance; ?>
                </p>
            </div>
            <div id="details"></div>
        </div>
        <script>
            function getDetails() {
                let categorie = document.getElementById("categorie").value;
                let keywords = document.getElementById("keywords").value;
                if (categorie === "" && keywords === "") {
                    if (document.getElementById("warning") !== null) {
                        return;
                    }
                    else {
                        const para = document.createElement("span");
                        para.textContent = "Veuillez entrer des mots-clés ou choisir une catégorie.";
                        para.setAttribute("id", "warning");
                        document.getElementById("details").append(para);
                        return;
                    };
                }

                let xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("details").innerHTML = this.responseText;
                    }
                };
                xmlhttp.open("GET", "../controler/get_details.php?categorie=" + categorie + "&keywords=" + keywords, true);
                xmlhttp.send();
            }
        </script>
</body>

</html>