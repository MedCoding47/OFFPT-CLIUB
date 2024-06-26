<?php
include_once("connexion.php");

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = "SELECT * FROM activities WHERE id = :id";
    $stmt = $connexion->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $activity = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = intval($_POST['id']);
    $title = $_POST['title'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $type = $_POST['type'];
    $image_url = $_POST['image_url'];

    $query = "UPDATE activities SET title = :title, description = :description, date = :date, type = :type, image_url = :image_url WHERE id = :id";
    $stmt = $connexion->prepare($query);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':date', $date);
    $stmt->bindParam(':type', $type);
    $stmt->bindParam(':image_url', $image_url);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    header("Location: list_activities.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modify Activity</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Activities</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="welcome.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="list_activities.php">List Activities</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <h1>Modify Activity</h1>
        <form action="modify_activity.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $activity['id']; ?>">
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo $activity['title']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="4" required><?php echo $activity['description']; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="date" class="form-label">Date</label>
                <input type="datetime-local" class="form-control" id="date" name="date" value="<?php echo date('Y-m-d\TH:i', strtotime($activity['date'])); ?>" required>
            </div>
            <div class="mb-3">
                <label for="type" class="form-label">Type</label>
                <select class="form-select" id="type" name="type" required>
                    <option value="Social Activities" <?php echo $activity['type'] == 'Social Activities' ? 'selected' : ''; ?>>Social Activities</option>
                    <option value="Exclusive Events" <?php echo $activity['type'] == 'Exclusive Events' ? 'selected' : ''; ?>>Exclusive Events</option>
                    <option value="Donate & Volunteer" <?php echo $activity['type'] == 'Donate & Volunteer' ? 'selected' : ''; ?>>Donate & Volunteer</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="image_url" class="form-label">Image URL</label>
                <input type="text" class="form-control" id="image_url" name="image_url" value="<?php echo $activity['image_url']; ?>">
            </div>
            <button type="submit" class="btn btn-primary">Modify Activity</button>
        </form>
    </div>
</body>
</html>
