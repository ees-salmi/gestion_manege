<?php
// Check if the id_manege parameter is set
if (isset($_POST['id_manege'])) {
  
  // Connect to the database
  include 'connexion.php' ;

  // Check if the connection was successful
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }

  // Escape the id_manege parameter to prevent SQL injection attacks
  $id_manege = mysqli_real_escape_string($conn, $_POST['id_manege']);

  // Delete the row from the manege table
  $sql = "DELETE FROM manege WHERE id_manege = $id_manege";

  if (mysqli_query($conn, $sql)) {
    // If the row was successfully deleted, redirect to the list page
    header("Location: ../vue/gerer_manege.php");
    exit();
  } else {
    // If an error occurred while deleting the row, display an error message
    echo "Error deleting record: " . mysqli_error($conn);
  }

  // Close the database connection
  mysqli_close($conn);
}
?>
