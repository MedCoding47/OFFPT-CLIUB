<?php
session_start();
include_once("connexion.php");

// Check if the user is logged in
if (!isset($_SESSION['CodeAdhrents'])) {
    header("Location: loginadhrent.php");
    exit();
}

// Fetch the club ID of the logged-in user
$user_id = $_SESSION['CodeAdhrents'];
$sql = "
    SELECT CodeClub
    FROM Adherents
    WHERE CodeAdhrents = :user_id
";
$stmt = $connexion->prepare($sql);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();

$user = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$user) {
    // Handle case where user is not found (shouldn't happen if logged in)
    header("Location: logout.php");
    exit();
}

$club_id = $user['CodeClub'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Evenements</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .event {
            display: flex;
            background-color: #fff;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .event img {
            width: 500px;
            height: 500px;
            object-fit: cover;
            border-radius: 8px;
            margin-right: 20px;
        }

        .event-details {
            flex: 1;
        }

        .event-name {
            font-size: 2em;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
        }

        .event-details p {
            font-size: 1.2em;
            margin: 10px 0;
        }

        .btn-primary, .btn-participer {
            display: inline-block;
            margin-bottom: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover, .btn-participer:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Liste des Evenements</h1>

        <?php
        try {
            $query = "SELECT e.code, c.libelle AS ClubName, e.jourP, e.DateR, e.Description, e.Observation, e.picture_path
                      FROM Evenements e
                      INNER JOIN Club c ON e.CodeClub = c.CodeClub
                      WHERE e.CodeClub = :club_id";
            $pdostmt = $connexion->prepare($query);
            $pdostmt->bindParam(':club_id', $club_id, PDO::PARAM_INT);
            $pdostmt->execute();

            while ($ligne = $pdostmt->fetch(PDO::FETCH_ASSOC)):
        ?>
            <div class="event">
                <?php if (!empty($ligne["picture_path"])): ?>
                    <img src="<?php echo htmlspecialchars($ligne["picture_path"]); ?>" alt="Event Picture">
                <?php else: ?>
                    <img src="default-placeholder.png" alt="No Picture Available">
                <?php endif; ?>
                <div class="event-details">
                    <div class="event-name">
                        <?php echo htmlspecialchars($ligne["ClubName"]); ?>
                    </div>
                    <p><strong>Code:</strong> <?php echo htmlspecialchars($ligne["code"]); ?></p>
                    <p><strong>Jour P:</strong> <?php echo htmlspecialchars($ligne["jourP"]); ?></p>
                    <p><strong>Date R:</strong> <?php echo htmlspecialchars($ligne["DateR"]); ?></p>
                    <p><strong>Description:</strong> <?php echo htmlspecialchars($ligne["Description"]); ?></p>
                    <p><strong>Observation:</strong> <?php echo htmlspecialchars($ligne["Observation"]); ?></p>
                    <a href="participer.php?event_id=<?php echo htmlspecialchars($ligne['code']); ?>" class="btn btn-participer">Participer</a>
                </div>
            </div>
        <?php
            endwhile;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        ?>
    </div>
</body>
</html>