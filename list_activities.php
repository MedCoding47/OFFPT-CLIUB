<?php
include_once("connexion.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $id = intval($_POST['id']);
    $query = "DELETE FROM activities WHERE id = :id";
    $stmt = $connexion->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    header("Location: list_activities.php");
    exit();
}

$query = "SELECT * FROM activities ORDER BY date DESC";
$stmt = $connexion->prepare($query);
$stmt->execute();
$activities = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Activities</title>
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
                    <a class="nav-link" href="add_activity.php">Add Activity</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="mb-4">List of Activities</h1>

        <div id="social-activities" class="mb-5">
            <h2>Social Activities</h2>
            <div class="row">
                <?php foreach ($activities as $activity): ?>
                    <?php if ($activity['type'] == 'Social Activities'): ?>
                        <div class="col-md-4">
                            <div class="card mb-4">
                                <?php if (!empty($activity['image_url'])): ?>
                                    <img src="<?php echo $activity['image_url']; ?>" class="card-img-top" alt="Activity Image">
                                <?php endif; ?>
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $activity['title']; ?></h5>
                                    <p class="card-text"><?php echo $activity['description']; ?></p>
                                    <p class="card-text"><small class="text-muted"><?php echo date('Y-m-d H:i', strtotime($activity['date'])); ?></small></p>
                                    <a href="modify_activity.php?id=<?php echo $activity['id']; ?>" class="btn btn-success">Modify</a>
                                    <form action="list_activities.php" method="POST" class="d-inline">
                                        <input type="hidden" name="id" value="<?php echo $activity['id']; ?>">
                                        <button type="submit" name="delete" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this activity?')">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>

        <div id="exclusive-events" class="mb-5">
            <h2>Exclusive Events</h2>
            <div class="row">
                <?php foreach ($activities as $activity): ?>
                    <?php if ($activity['type'] == 'Exclusive Events'): ?>
                        <div class="col-md-4">
                            <div class="card mb-4">
                                <?php if (!empty($activity['image_url'])): ?>
                                    <img src="<?php echo $activity['image_url']; ?>" class="card-img-top" alt="Activity Image">
                                <?php endif; ?>
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $activity['title']; ?></h5>
                                    <p class="card-text"><?php echo $activity['description']; ?></p>
                                    <p class="card-text"><small class="text-muted"><?php echo date('Y-m-d H:i', strtotime($activity['date'])); ?></small></p>
                                    <a href="modify_activity.php?id=<?php echo $activity['id']; ?>" class="btn btn-success">Modify</a>
                                    <form action="list_activities.php" method="POST" class="d-inline">
                                        <input type="hidden" name="id" value="<?php echo $activity['id']; ?>">
                                        <button type="submit" name="delete" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this activity?')">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>

        <div id="donate-volunteer" class="mb-5">
            <h2>Donate & Volunteer</h2>
            <div class="row">
                <?php foreach ($activities as $activity): ?>
                    <?php if ($activity['type'] == 'Donate & Volunteer'): ?>
                        <div class="col-md-4">
                            <div class="card mb-4">
                                <?php if (!empty($activity['image_url'])): ?>
                                    <img src="<?php echo $activity['image_url']; ?>" class="card-img-top" alt="Activity Image">
                                <?php endif; ?>
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $activity['title']; ?></h5>
                                    <p class="card-text"><?php echo $activity['description']; ?></p>
                                    <p class="card-text"><small class="text-muted"><?php echo date('Y-m-d H:i', strtotime($activity['date'])); ?></small></p>
                                    <a href="modify_activity.php?id=<?php echo $activity['id']; ?>" class="btn btn-success">Modify</a>
                                    <form action="list_activities.php" method="POST" class="d-inline">
                                        <input type="hidden" name="id" value="<?php echo $activity['id']; ?>">
                                        <button type="submit" name="delete" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this activity?')">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</body>
</html>
