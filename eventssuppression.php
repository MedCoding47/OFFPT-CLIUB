<?php
include_once("connexion.php");

if (isset($_GET['id'])) {
    $eventId = $_GET['id'];

    try {
        // Begin a transaction
        $connexion->beginTransaction();

        // Find and delete the image file if it exists
        $query = "SELECT picture_path FROM Evenements WHERE code = :id";
        $pdostmt = $connexion->prepare($query);
        $pdostmt->execute(['id' => $eventId]);
        $event = $pdostmt->fetch(PDO::FETCH_ASSOC);
        $pdostmt->closeCursor();

        if ($event && !empty($event['picture_path']) && file_exists($event['picture_path'])) {
            unlink($event['picture_path']);
        }

        // Delete records in the EventPhotos table
        $query = "SELECT photo_path FROM EventPhotos WHERE event_id = :id";
        $pdostmt = $connexion->prepare($query);
        $pdostmt->execute(['id' => $eventId]);
        $photos = $pdostmt->fetchAll(PDO::FETCH_ASSOC);
        $pdostmt->closeCursor();

        foreach ($photos as $photo) {
            if (!empty($photo['photo_path']) && file_exists($photo['photo_path'])) {
                unlink($photo['photo_path']);
            }
        }

        $query = "DELETE FROM EventPhotos WHERE event_id = :id";
        $pdostmt = $connexion->prepare($query);
        $pdostmt->execute(['id' => $eventId]);
        $pdostmt->closeCursor();

        // Delete records in the Reviews table
        $query = "DELETE FROM Reviews WHERE event_code = :id";
        $pdostmt = $connexion->prepare($query);
        $pdostmt->execute(['id' => $eventId]);
        $pdostmt->closeCursor();

        // Delete records in the EventParticipants table
        $query = "DELETE FROM EventParticipants WHERE event_id = :id";
        $pdostmt = $connexion->prepare($query);
        $pdostmt->execute(['id' => $eventId]);
        $pdostmt->closeCursor();

        // Delete the event from the Evenements table
        $query = "DELETE FROM Evenements WHERE code = :id";
        $pdostmt = $connexion->prepare($query);
        $pdostmt->execute(['id' => $eventId]);
        $pdostmt->closeCursor();

        // Commit the transaction
        $connexion->commit();

        // Redirect to the list of events page after deletion
        header("Location: liste_evenements.php");
        exit();
    } catch (Exception $e) {
        // Rollback the transaction in case of error
        $connexion->rollBack();
        echo "Failed to delete event: " . $e->getMessage();
    }
} else {
    // If no id is provided, redirect to the list of events page
    header("Location: liste_evenements.php");
    exit();
}
?>
