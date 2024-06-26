<?php
session_start();
include_once("connexion.php");

if (!isset($_SESSION['CodeAdhrents']) && !isset($_SESSION['CodeEleve'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit();
}

$user_id = isset($_SESSION['CodeAdhrents']) ? $_SESSION['CodeAdhrents'] : $_SESSION['CodeEleve'];
$sql = "SELECT messages.*, 
               CASE 
                   WHEN messages.sender_id = :user_id THEN 'self'
                   ELSE 'other'
               END AS sender_type
        FROM messages
        WHERE sender_id = :user_id OR receiver_id = :user_id
        ORDER BY timestamp ASC";
$stmt = $connexion->prepare($sql);
$stmt->execute(['user_id' => $user_id]);
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode(['success' => true, 'messages' => $messages]);

