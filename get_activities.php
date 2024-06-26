<?php
include_once("connexion.php");

$sql = "SELECT * FROM activities ORDER BY date DESC";
$stmt = $connexion->prepare($sql);
$stmt->execute();
$activities = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode(['success' => true, 'activities' => $activities]);
?>
