<?php
session_start();
include_once("connexion.php");

if (!isset($_SESSION['CodeAdhrents'])) {
    header('Location: loginadhrent.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['event_id'])) {
    $event_id = $_POST['event_id'];
    $user_id = $_SESSION['CodeAdhrents'];

    // Check if the user has already participated in the event
    $query = "SELECT COUNT(*) FROM EventParticipants WHERE CodeAdhrents = :user_id AND event_id = :event_id";
    $pdostmt = $connexion->prepare($query);
    $pdostmt->execute(['user_id' => $user_id, 'event_id' => $event_id]);
    $count = $pdostmt->fetchColumn();

    if ($count > 0) {
        // User has already participated in this event
        $_SESSION['error_message'] = "Vous avez déjà participé à cet événement.";
        header('Location: profiladhrent.php');
        exit();
    }

    // Process payment here (this is a placeholder for actual payment processing logic)
    $payment_successful = true; // Assume payment is successful for now

    if ($payment_successful) {
        // Record the participation in the database
        $query = "INSERT INTO EventParticipants (CodeAdhrents, event_id, payment_status) VALUES (:user_id, :event_id, 'paid')";
        $pdostmt = $connexion->prepare($query);
        $pdostmt->execute(['user_id' => $user_id, 'event_id' => $event_id]);

        // Redirect to the profile page with a success message
        $_SESSION['success_message'] = "Votre participation à l'événement a été confirmée avec succès.";
        header('Location: profiladhrent.php');
        exit();
    } else {
        // Handle payment failure case
        $_SESSION['error_message'] = "Le paiement a échoué. Veuillez réessayer.";
        header('Location: profiladhrent.php');
        exit();
    }
} else {
    echo "Invalid request.";
}
?>
