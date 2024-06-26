<?php
include_once("connexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $code_adherent = $_POST['code_adherent'];
    
    $query = "UPDATE Adherents SET valide = TRUE WHERE CodeAdhrents = :code_adherent";
    $pdostmt = $connexion->prepare($query);
    $pdostmt->execute(['code_adherent' => $code_adherent]);
    
    header("Location: liste_adherents.php");
    exit();
}
?>
