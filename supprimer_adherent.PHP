<?php
include_once("connexion.php");

// Vérifie si l'identifiant de l'adhérent est passé en paramètre
if(isset($_GET['id'])) {
    $id = $_GET['id'];

    // Vérifie s'il y a des références à cet adhérent dans la table EventParticipants
    $query_check_reference = "SELECT COUNT(*) AS count_references FROM EventParticipants WHERE CodeAdhrents = :id";
    $pdostmt_check_reference = $connexion->prepare($query_check_reference);
    $pdostmt_check_reference->bindParam(':id', $id);
    $pdostmt_check_reference->execute();
    $result_check_reference = $pdostmt_check_reference->fetch(PDO::FETCH_ASSOC);

    // Si des références existent, supprimez-les d'abord
    if ($result_check_reference['count_references'] > 0) {
        $query_delete_references = "DELETE FROM EventParticipants WHERE CodeAdhrents = :id";
        $pdostmt_delete_references = $connexion->prepare($query_delete_references);
        $pdostmt_delete_references->bindParam(':id', $id);
        $pdostmt_delete_references->execute();
    }

    // Ensuite, supprimez l'adhérent de la table Adherents
    $query_delete_adherent = "DELETE FROM Adherents WHERE CodeAdhrents = :id";
    $pdostmt_delete_adherent = $connexion->prepare($query_delete_adherent);
    $pdostmt_delete_adherent->bindParam(':id', $id);
    $pdostmt_delete_adherent->execute();

    // Redirection vers la liste des adhérents après suppression
    header("Location: liste_adherents.php");
    exit;
} else {
    // Redirection si l'identifiant n'est pas passé en paramètre
    header("Location: liste_adherents.php");
    exit;
}
?>
