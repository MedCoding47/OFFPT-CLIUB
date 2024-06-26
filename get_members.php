<?php
// get_members.php - Fetches members list from the database and returns JSON response

session_start();
include_once("connexion.php");

// Check if user is logged in and is admin
if (!isset($_SESSION['CodeAdhrents']) || $_SESSION['is_admin'] != 1) {
    echo json_encode(['success' => false, 'message' => 'Not authorized']);
    exit();
}

$sql = "SELECT CodeAdhrents AS id, Nom AS name, email FROM Adherents";
$stmt = $connexion->query($sql);
$members = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode(['success' => true, 'members' => $members]);
?>
