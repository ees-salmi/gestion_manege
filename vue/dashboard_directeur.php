<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="dashboard_style.css">
  <title>Dashboard - Directeur</title>
</head>

<body>
  <?php
  session_start();
  if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
  }

  // Vérifier le rôle de l'utilisateur à partir de la base de données et rediriger vers la page appropriée
  $db_username = 'root';
  $db_password = '';
  $db_name = 'bdd_manege';
  $db_host = 'localhost';
  $db = mysqli_connect($db_host, $db_username, $db_password, $db_name)
    or die('could not connect to database');

  $username = mysqli_real_escape_string($db, $_SESSION['username']);

  // Récupère le rôle de l'utilisateur à partir de la base de données
  $role_query = "SELECT type_personnel FROM personnel WHERE nom_personnel = '$username'";
  $role_result = mysqli_query($db, $role_query);
  $role_row = mysqli_fetch_assoc($role_result);
  $role = $role_row['type_personnel'];

  // Récupère les informations du réalisateur à partir de la base de données
  $director_query = "SELECT prenom_personnel, nom_personnel, date_naissance FROM personnel WHERE nom_personnel = '$username'";
  $director_result = mysqli_query($db, $director_query);
  $director_row = mysqli_fetch_assoc($director_result);
  $prenom = $director_row['prenom_personnel'];
  $nom_famille = $director_row['nom_personnel'];
  $date_naissance = $director_row['date_naissance'];

  mysqli_close($db);
  ?>
  <div class="container">
    <div class="header">
      <h1>Dashboard Directeur</h1>
      <div class="btn">
        <a href="../controler/modifier_profil.php">Modifier le profil</a>
        <a href="../controler/logout.php">Déconnexion</a>
      </div>
    </div>
    <div class='menu'>
      <?php if ($role === 'Directeur') { ?>
        <button onclick="afficher_ajouter_manege_formulaire()">Ajouter un manège</button>
        <button onclick="afficher_ajouter_boutique_formulaire()">Ajouter une boutique</button>
      <?php } ?>
    </div>
    <div id="result-container">
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
        <h1>Bonjour, Directeur
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

      /* Show the add ride form */
      function afficher_ajouter_manege_formulaire() {
        const modal = document.createElement("div");
        modal.classList.add("modal");
        modal.innerHTML = `
        <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Ajouter un manège</h2>
        <form class="ride-form" action="../controler/ajouter_manege.php" method="POST">
          <label for="name">Nom du manège:</label>
          <input type="text" id="name" name="name" required>
          <label for="description">Description:</label>
          <textarea id="description" name="description" rows="2"></textarea>
          <label for="Taille_min_Client">Taille min Client:</label>
          <input type="number" id="Taille_min_Client" name="Taille_min_Client" required>
         <label for="id_Atelier">Id Atelier:</label>
          <select id="id_Atelier" name="id_Atelier" required>
            <option value="501">Atelier 501</option>
            <option value="502">Atelier 502</option>
            <option value="503">Atelier 503</option>
          </select>
         <label for="id_zone">Id zone:</label>
          <select id="id_zone" name="id_zone" required>
            <option value="1">Zone 1</option>
            <option value="2">Zone 2</option>
            <option value="3">Zone 3</option>
          </select>
          <label for="id_famille">Id famille:</label>
          <select id="id_famille" name="id_famille" required>
            <option value="FM01">Famille 01</option>
            <option value="FM02">Famille 02</option>
            <option value="FM03">Famille 03</option>
          </select>
          <button type="submit">Ajouter</button>
        </form>
      </div>

  `;
        document.body.appendChild(modal);
        modal.addEventListener('click', (event) => {
          if (event.target === modal) {
            modal.remove();
          }
        });
      }

      function afficher_ajouter_boutique_formulaire() {
        const modal = document.createElement("div");
        modal.classList.add("modal");
        modal.innerHTML = `
        <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Ajouter une Boutique</h2>
        <form class="ride-form" action="../controler/ajouter_boutique.php" method="POST">
          <label for="type">Type du boutique:</label>
          <input type="text" id="type" name="type" required>
          <label for="responsable">Responsable Id:</label>
          <input type="text" id="responsable" name="responsable"></textarea>
          <label for="chiffre_affaire">Chiffre d'affaire:</label>
          <input type="number" id="chiffre_affaire" name="chiffre_affaire" required>
          <label for="nombre_client_quotid">Nombre client quotidien:</label>
          <input type="number" id="nombre_client_quotid" name="nombre_client_quotid" required>
         <label for="id_zone">Id zone:</label>
          <select id="id_zone" name="id_zone" required>
            <option value="1">Zone 1</option>
            <option value="2">Zone 2</option>
            <option value="3">Zone 3</option>
          </select>
          <button type="submit">Ajouter</button>
        </form>
  `;
        document.body.appendChild(modal);
        // hide the popup when the user clicks outside of it
        modal.addEventListener('click', (event) => {
          if (event.target === modal) {
            modal.remove();
          }
        });
      }

      function closeModal() {
        const modal = document.querySelector(".modal");
        document.body.removeChild(modal);
      }

      function resultat_click_manege(id_manege, nom_manege, description, taille_min_client, id_atelier, id_zone, id_famille) {
        const popup = document.createElement('div');
        popup.classList.add('modal');

        // add the popup content
        popup.innerHTML = `
        <div class="popup-content">
        <h3>${nom_manege}</h3>
        <p>Description: ${description}</p>
        <p>Taille min clients: ${taille_min_client}</p>
        <p>ID Atelier: ${id_atelier}</p>
        <p>ID Zone: ${id_zone}</p>
        <p>ID Famille: ${id_famille}</p>
        </div>
        <a id="update" href="../controler/modify_manege.php?id_manege=${id_manege}">Modifier ce manege</a>
        <a id="delete" href="../controler/delete_manege.php?id_manege=${id_manege}">Supprimer ce manege</a>

  `;

        document.body.appendChild(popup);

        popup.addEventListener('click', (event) => {
          if (event.target === popup) {
            popup.remove();
          }
        });
      }


      function resultat_click_boutique(id_boutique, type_boutique, chiffre_affaire, nb_clients_quotid, responsable_id, id_zone) {

        const popup = document.createElement('div');
        popup.classList.add('modal');

        popup.innerHTML = `
        <div class="popup-content">
        <h3>${type_boutique}</h3>
        <p>Chiffre d'affaire: ${chiffre_affaire}</p>
        <p>Nombre de clients quotidiens: ${nb_clients_quotid}</p>
        <p>Responsable ID: ${responsable_id}</p>
        <p>Zone ID: ${id_zone}</p>
        </div>
        <a id="update" href="../controler/modify_boutique.php?id_boutique=${id_boutique}">Modifier ce boutique</a>
        <a id="delete" href="../controler/delete_boutique.php?id_boutique=${id_boutique}">Supprimer ce boutique</a>
      `;

        document.body.appendChild(popup);

        popup.addEventListener('click', (event) => {
          if (event.target === popup) {
            popup.remove();
          }
        });
      }

    </script>
</body>

</html>