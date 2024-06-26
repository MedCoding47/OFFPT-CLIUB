<?php
include_once("connexion.php"); // Include your database connection file

ob_start(); // Start output buffering

if (isset($_GET['id'])) {
    $eventId = $_GET['id'];

    // Fetch event details from the database
    $query = "SELECT * FROM Evenements WHERE code = :id";
    $pdostmt = $connexion->prepare($query);
    $pdostmt->execute(['id' => $eventId]);
    $event = $pdostmt->fetch(PDO::FETCH_ASSOC);
    
    if ($event) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Handle file upload
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = 'images/';
                $uploadFile = $uploadDir . basename($_FILES['image']['name']);
                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                    $imagePath = $uploadFile;
                } else {
                    echo "Échec du téléchargement de l'image.";
                    exit;
                }
            } else {
                $imagePath = $event['picture_path'];
            }

            // Update the event
            $updateQuery = "UPDATE Evenements 
                            SET CodeClub = :CodeClub, jourP = :jourP, DateR = :DateR, Description = :Description, Observation = :Observation, nom_event =:nom_event , picture_path = :image 
                            WHERE code = :id";
            $pdostmt = $connexion->prepare($updateQuery);
            $pdostmt->execute([
                'CodeClub' => $_POST['CodeClub'],
                'jourP' => $_POST['jourP'],
                'DateR' => $_POST['DateR'],
                'Description' => $_POST['Description'],
                'Observation' => $_POST['Observation'],
                'nom_event' => $_POST['nom_event'],
                'image' => $imagePath,
                'id' => $eventId
            ]);
            
            header("Location: liste_evenements.php");
            exit();
        }
    ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Modifier l'événement</title>
            <link rel="stylesheet" href="styles.css">
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f9f9f9;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    min-height: 100vh;
                }

                form {
                    background-color: #fff;
                    border-radius: 8px;
                    padding: 20px;
                    width: 400px;
                    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                }

                h1 {
                    font-size: 24px;
                    margin-bottom: 20px;
                }

                .form-group {
                    margin-bottom: 20px;
                }

                label {
                    display: block;
                    font-weight: bold;
                    margin-bottom: 8px;
                }

                input,
                textarea {
                    width: 100%;
                    padding: 10px;
                    border: 1px solid #ccc;
                    border-radius: 4px;
                    font-size: 14px;
                }

                button {
                    background-color: #007bff;
                    color: #fff;
                    border: none;
                    border-radius: 4px;
                    padding: 10px 20px;
                    cursor: pointer;
                    font-size: 14px;
                    transition: background-color 0.3s ease;
                }

                button:hover {
                    background-color: #0056b3;
                }
            </style>
        </head>
        <body>
            <h1>Modifier l'événement</h1>
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="CodeClub">Code Club:</label>
                    <input type="number" id="CodeClub" name="CodeClub" value="<?php echo $event['CodeClub']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="jourP">Event Date (jourP):</label>
                    <input type="date" id="jourP" name="jourP" value="<?php echo $event['jourP']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="DateR">Report Date (DateR):</label>
                    <input type="date" id="DateR" name="DateR" value="<?php echo $event['DateR']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="Description">Description:</label>
                    <textarea id="Description" name="Description" rows="4" required><?php echo $event['Description']; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="Observation">Observation:</label>
                    <textarea id="Observation" name="Observation" rows="4"><?php echo $event['Observation']; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="Observation">nom_event:</label>
                    <textarea id="nom_event" name="nom_event" ><?php echo $event['nom_event']; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="image">Image:</label>
                    <input type="file" id="image" name="image">
                    <?php if ($event['picture_path']): ?>
                        <img src="<?php echo $event['picture_path']; ?>" alt="Event Image" style="max-width: 100px; max-height: 100px;">
                    <?php endif; ?>
                </div>
                <button type="submit">Mettre à jour l'événement</button>
            </form>
        </body>
        </html>
    <?php
    } else {
        echo "<p>Événement non trouvé.</p>";
    }
} else {
    echo "<p>ID d'événement non fourni.</p>";
}

ob_end_flush(); // End output buffering and flush the output
?>
