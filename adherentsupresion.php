

<?php

include_once("connexion.php");

if (!empty($_GET["id"])) {
    $CodeStagiaire = $_GET["id"];
    $query = "DELETE FROM Adherents WHERE CodeStagiaire = :CodeStagiaire";
    $pdostmt = $connexion->prepare($query);
    $pdostmt->execute(["CodeStagiaire" => $CodeStagiaire]);
    $pdostmt->closeCursor();
    header("Location:liste_adherents.php");
    exit(); 
}
?>

