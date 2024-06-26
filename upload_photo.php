<?php
session_start(); // Démarrage de la session

include_once('connexion.php'); // Connexion à la base de données

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
        $event_id = $_POST['event_id'];
        $user_id = $_SESSION['user_id'];

        if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
            $allowed_extensions = array('jpg', 'jpeg', 'png', 'gif');
            $file_info = pathinfo($_FILES['photo']['name']);
            $file_extension = strtolower($file_info['extension']);

            if (in_array($file_extension, $allowed_extensions)) {
                $upload_dir = 'uploads/';
                $file_name = uniqid() . '.' . $file_extension;
                $upload_path = $upload_dir . $file_name;

                if (move_uploaded_file($_FILES['photo']['tmp_name'], $upload_path)) {
                    $sql = "INSERT INTO EventPhotos (event_id, photo_path, user_id) VALUES (:event_id, :photo_path, :user_id)";
                    $stmt = $connexion->prepare($sql);
                    $stmt->bindParam(':event_id', $event_id, PDO::PARAM_INT);
                    $stmt->bindParam(':photo_path', $file_name, PDO::PARAM_STR);
                    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

                    if ($stmt->execute()) {
                        echo "Photo uploaded successfully!";
                    } else {
                        echo "Failed to save photo information. Error: " . implode(" ", $stmt->errorInfo());
                    }
                } else {
                    echo "Failed to move uploaded file.";
                }
            } else {
                echo "Invalid file extension.";
            }
        } else {
            echo "File upload error.";
        }
    } else {
        echo "User ID not set in session or empty.";
    }
} else {
    echo "Invalid request method.";
}
?>
