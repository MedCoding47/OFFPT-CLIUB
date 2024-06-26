<?php
// delete_member.php - Deletes a member from the database

session_start();
include_once("connexion.php");

// Check if user is logged in and is admin
if (!isset($_SESSION['CodeAdhrents']) || $_SESSION['is_admin'] != 1) {
    echo json_encode(['success' => false, 'message' => 'Not authorized']);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);
$memberId = $data['memberId'] ?? '';

if ($memberId) {
    $sql = "DELETE FROM Adherents WHERE CodeAdhrents = :memberId";
    $stmt = $connexion->prepare($sql);
    $stmt->bindParam(':memberId', $memberId, PDO::PARAM_INT);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete member']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid member ID']);
}
?>
