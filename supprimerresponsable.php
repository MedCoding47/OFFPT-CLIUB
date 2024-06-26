<?php

include_once("connexion.php");

if (!empty($_GET["id"])) {
    $Code = $_GET["id"];

    // Directly execute the deletion query
    $query = "DELETE FROM Responsable WHERE Code = $Code";

    try {
        $rowCount = $connexion->exec($query);

        if ($rowCount !== false && $rowCount > 0) {
            // Redirect to the listing page if deletion was successful
            header("Location: ListeResponsables.php");
            exit();
        } else {
            // Handle the case where no record was deleted
            echo "Error: No record deleted. Possibly the record with Code $Code does not exist.";
        }
    } catch (PDOException $e) {
        // Handle any PDO exceptions (database errors)
        echo "Database error: " . $e->getMessage();
    }
} else {
    // Handle the case where id is not set or is empty
    echo "Error: No ID provided for deletion.";
}
?>