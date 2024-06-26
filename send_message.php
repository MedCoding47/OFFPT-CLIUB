<?php
session_start();
include_once("connexion.php");

if (!isset($_SESSION['CodeAdhrents']) && !isset($_SESSION['CodeEleve'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit();
}

$input = json_decode(file_get_contents('php://input'), true);
$message = $input['message'];
$sender_id = isset($_SESSION['CodeAdhrents']) ? $_SESSION['CodeAdhrents'] : $_SESSION['CodeEleve'];
$receiver_id = isset($_SESSION['CodeAdhrents']) ? 1 : $input['receiver_id']; // Assuming admin has user_id = 1

$sql = "INSERT INTO messages (sender_id, receiver_id, message) VALUES (?, ?, ?)";
$stmt = $connexion->prepare($sql);
$stmt->execute([$sender_id, $receiver_id, $message]);

echo json_encode(['success' => true]);
?>
