<?php
// retrieve the id_manege parameter from the URL
$id_manege = $_GET['id_manege'];

// connect to the database
include_once 'connexion.php'
// query the database for the current values of the manege to be updated
$sql = "SELECT * FROM manege WHERE id_manege = $id_manege ";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

// close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Update Manege</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="card">
		<h2>Update Manege</h2>
		<form action="ajouter_manege.php" method="post">
			<input type="hidden" name="id_manege" value="<?php echo $row['id_manege']; ?>">
			<label for="nom_manege">Nom du Manege:</label>
			<input type="text" id="nom_manege" name="nom_manege" value="<?php echo $row['nom_manege']; ?>" required>
			<label for="description">Description:</label>
			<input type="text" id="description" name="description" value="<?php echo $row['description']; ?>" required>
			<label for="taille_min_client">Taille minimale du client:</label>
			<input type="number" id="taille_min_client" name="taille_min_client" value="<?php echo $row['taille_min_client']; ?>" required>
			<label for="id_atelier">ID de l'atelier:</label>
			<input type="number" id="id_atelier" name="id_atelier" value="<?php echo $row['id_atelier']; ?>" required>
			<label for="id_zone">ID de la zone:</label>
			<input type="number" id="id_zone" name="id_zone" value="<?php echo $row['id_zone']; ?>" required>
			<label for="id_famille">ID de la famille:</label>
			<input type="number" id="id_famille" name="id_famille" value="<?php echo $row['id_famille']; ?>" required>
			<button type="submit">Update Manege</button>
		</form>
	</div>
</body>
</html>
