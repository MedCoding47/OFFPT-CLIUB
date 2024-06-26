<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Event</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* styles.css */
        /* Reset some default styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Basic styling for the form */
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

        /* Responsive adjustments */
        @media screen and (max-width: 480px) {
            form {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <h1>Add Event</h1>
    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="CodeClub">Code Club:</label>
            <input type="number" id="CodeClub" name="CodeClub" required>
        </div>
        <div class="form-group">
            <label for="nom_event">Event Name:</label>
            <input type="text" id="nom_event" name="nom_event" required>
        </div>
        <div class="form-group">
            <label for="jourP">Event Date (jourP):</label>
            <input type="date" id="jourP" name="jourP" required>
        </div>
        <div class="form-group">
            <label for="DateR">Report Date (DateR):</label>
            <input type="date" id="DateR" name="DateR" required>
        </div>
        <div class="form-group">
            <label for="Description">Description:</label>
            <textarea id="Description" name="Description" rows="4" required></textarea>
        </div>
        <div class="form-group">
            <label for="Observation">Observation:</label>
            <textarea id="Observation" name="Observation" rows="4"></textarea>
        </div>
        <div class="form-group">
            <label for="picture_path">Upload Picture:</label>
            <input type="file" id="picture_path" name="image">
        </div>
        <button type="submit">Add Event</button>
    </form>

    <?php
    include_once("connexion.php");

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (!empty($_FILES["image"]["name"])) {
            if (!is_dir("images")) {
                mkdir("images");
            }
            $target_file = "images/" . basename($_FILES["image"]["name"]);
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                echo "The file " . basename($_FILES["image"]["name"]) . " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }

        if (!empty($_POST["CodeClub"]) && !empty($_POST["nom_event"]) && !empty($_POST["jourP"]) && !empty($_POST["DateR"]) && !empty($_POST["Description"])) {
            $query = "INSERT INTO Evenements (CodeClub, nom_event, jourP, DateR, Description, Observation, picture_path) VALUES (:CodeClub, :nom_event, :jourP, :DateR, :Description, :Observation, :image)";
            $pdostmt = $connexion->prepare($query);
            $pdostmt->execute([
                "CodeClub" => $_POST["CodeClub"],
                "nom_event" => $_POST["nom_event"],
                "jourP" => $_POST["jourP"],
                "DateR" => $_POST["DateR"],
                "Description" => $_POST["Description"],
                "Observation" => $_POST["Observation"],
                "image" => !empty($_FILES["image"]["name"]) ? $target_file : null
            ]);
            $pdostmt->closeCursor();

            header("Location: liste_evenements.php");
            exit();
        } else {
            echo "Please fill in all required fields.";
        }
    }
    ?>
</body>
</html>
