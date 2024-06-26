<?php
session_start();
include_once("connexion.php");


$sql_photos = "SELECT p.*, a.Nom, a.prenom, e.Description AS EventDescription FROM EventPhotos p INNER JOIN Adherents a ON p.user_id = a.CodeAdhrents INNER JOIN Evenements e ON p.event_id = e.Code WHERE p.approved = 0";
$stmt_photos = $connexion->prepare($sql_photos);
$stmt_photos->execute();
$pending_photos = $stmt_photos->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $photo_id = $_POST['photo_id'];
    $action = $_POST['action'];
    
    if ($action === 'approve') {
        $sql = "UPDATE EventPhotos SET approved = 1 WHERE id = :photo_id";
    } elseif ($action === 'reject') {
        $sql = "DELETE FROM EventPhotos WHERE id = :photo_id";
    }

    $stmt = $connexion->prepare($sql);
    $stmt->bindParam(':photo_id', $photo_id, PDO::PARAM_INT);
    $stmt->execute();

    header("Location: admin_approval.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Photo Approval</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="test.css">
</head>
<body>
<header>
    <div class="logo">
        <p><span>Admin</span>Dashboard</p>
    </div>
    <ul class="menu">
        <li><a href="acceuil.php">Accueil</a></li>
        <li><a href="admin_logout.php">Logout</a></li>
    </ul>
    <div class="toggle_menu"></div>
</header>
<br>
<br>
<br>
<br>
<br>
<br>
<div class="container">
    <h2>Admin Photo Approval</h2>
    <?php if (empty($pending_photos)): ?>
        <p>No photos pending approval.</p>
    <?php else: ?>
        <div class="photo-gallery">
            <?php foreach ($pending_photos as $photo): ?>
                <div class="photo-item">
                    <img src="uploads/<?php echo htmlspecialchars($photo['photo_path']); ?>" alt="Pending Photo">
                    <p><?php echo htmlspecialchars($photo['Nom'] . ' ' . $photo['prenom']); ?> (Event: <?php echo htmlspecialchars($photo['EventDescription']); ?>)</p>
                    <form action="admin_approval.php" method="post">
                        <input type="hidden" name="photo_id" value="<?php echo htmlspecialchars($photo['id']); ?>">
                        <button type="submit" name="action" value="approve" class="btn btn-success">Approve</button>
                        <button type="submit" name="action" value="reject" class="btn btn-danger">Reject</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
</body>
</html>
