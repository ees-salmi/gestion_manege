<?php
session_start();
if(isset($_POST['username']) && isset($_POST['password']))
{
 // connexion à la base de données
 include '../myparam.inc.php';

// Use the variables defined in config.php
$db_host = MYHOST;
$db_username = MYUSER;
$db_password = MYPASS;
$db_name = MYBASE;

 $db = mysqli_connect($db_host, $db_username, $db_password,$db_name)
 or die('could not connect to database');
 
 // on applique les deux fonctions mysqli_real_escape_string et htmlspecialchars
 // pour éliminer toute attaque de type injection SQL et XSS
 $username = mysqli_real_escape_string($db,htmlspecialchars($_POST['username'])); 
 $password = mysqli_real_escape_string($db,htmlspecialchars($_POST['password']));
 
 if($username !== "" && $password !== "")
    {
        // select the user's role from the database
        $requete = "SELECT type_personnel FROM personnel WHERE nom_personnel = '".$username."' AND mot_de_passe = '".$password."'";
        $exec_requete = mysqli_query($db, $requete);
        $reponse = mysqli_fetch_array($exec_requete);
        $role = $reponse['type_personnel'];

        if($role != "") // user exists and role is not empty
        {
            $_SESSION['username'] = $username;
            $_SESSION['user_type'] = $role;

            // redirect to appropriate page based on user role
            if($role == 'Directeur')
            {
                header('Location: ../vue/dashboard_directeur.php');
            }
            else if($role == 'Vendeur')
            {
                header('Location: ../vue/dashboard_vendeur.php');
            }
            else if($role == 'Serveur')
            {
                header('Location: ../vue/dashboard_serveur.php');
            }
            else if($role == 'CM')
            {
                header('Location: ../vue/dashboard_CM.php');
            }
            else if($role == 'Technicien')
            {
                header('Location: ../vue/dashboard_technicien.php');
            }
        }
        else // username or password is incorrect
        {
            header('Location: ../vue/login.php?erreur=1'); // utilisateur ou mot de passe incorrect
        }
    }
    else // username or password is empty
    {
        header('Location: ../vue/login.php?erreur=2'); // utilisateur ou mot de passe vide
    }
}
else
{
    header('Location: ../vue/login.php');
}
mysqli_close($db); // fermer la connexion
?>
