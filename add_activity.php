<?php
include_once("connexion.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $type = $_POST['type'];
    $image_url = $_POST['image_url'];

    $query = "INSERT INTO activities (title, description, date, type, image_url) 
              VALUES (:title, :description, :date, :type, :image_url)";
    $stmt = $connexion->prepare($query);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':date', $date);
    $stmt->bindParam(':type', $type);
    $stmt->bindParam(':image_url', $image_url);
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
    <title>Add Activity</title>
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
        <h1>Add Activity</h1>
        <form action="add_activity.php" method="POST">
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
            </div>
            <div class="mb-3">
                <label for="date" class="form-label">Date</label>
                <input type="datetime-local" class="form-control" id="date" name="date" required>
            </div>
            <div class="mb-3">
                <label for="type" class="form-label">Type</label>
                <select class="form-select" id="type" name="type" required>
                    <option value="Social Activities">Social Activities</option>
                    <option value="Exclusive Events">Exclusive Events</option>
                    <option value="Donate & Volunteer">Donate & Volunteer</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="image_url" class="form-label">Image URL</label>
                <input type="text" class="form-control" id="image_url" name="image_url">
            </div>
            <button type="submit" class="btn btn-primary">Add Activity</button>
        </form>
    </div>
</body>
</html>
