<?php
session_start();
include_once("connexion.php");

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the user is logged in
if (!isset($_SESSION['CodeAdhrents'])) {
    header("Location: loginadhrent.php");
    exit();
}

$user_id = $_SESSION['CodeAdhrents'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['Nom'];
    $prenom = $_POST['prenom'];
    $telephone = $_POST['telephone'];
    $email = $_POST['email'];
    $fielere = $_POST['fielere'];
    $picture = $_FILES['picture'];

    // Ensure the variables are not empty
    if (!empty($nom) && !empty($prenom) && !empty($telephone) && !empty($email) && !empty($fielere)) {
        $picture_filename = null;

        if ($picture['error'] == UPLOAD_ERR_OK) {
            $picture_filename = basename($picture['name']);
            $target_dir = "uploads/";
            $target_file = $target_dir . $picture_filename;

            // Ensure the uploads directory exists
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0755, true);
            }

            // Move the uploaded file to the target directory
            if (!move_uploaded_file($picture['tmp_name'], $target_file)) {
                $error_message = "Erreur lors de l'upload du fichier.";
            }
        } elseif ($picture['error'] != UPLOAD_ERR_NO_FILE) {
            $error_message = "Erreur lors de l'upload du fichier.";
        }

        if (!isset($error_message)) {
            $sql_update = "UPDATE Adherents SET Nom = :nom, prenom = :prenom, telephone = :telephone, email = :email, fielere = :fielere";
            if ($picture_filename) {
                $sql_update .= ", picture = :picture";
            }
            $sql_update .= " WHERE CodeAdhrents = :user_id";

            $stmt = $connexion->prepare($sql_update);
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':prenom', $prenom);
            $stmt->bindParam(':telephone', $telephone);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':fielere', $fielere);
            if ($picture_filename) {
                $stmt->bindParam(':picture', $picture_filename);
            }
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                // Redirect back to profile page after update
                header("Location: profiladhrent.php");
                exit();
            } else {
                $error_message = "Une erreur s'est produite lors de la mise à jour du profil.";
            }
        }
    } else {
        $error_message = "Tous les champs sont obligatoires.";
    }
}

// Fetch user information from the database
$sql = "SELECT * FROM Adherents WHERE CodeAdhrents = :user_id";
$stmt = $connexion->prepare($sql);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();

$user = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$user) {
    // Handle case where user is not found (shouldn't happen if logged in)
    header("Location: logout.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Profil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <style>
        .edit-container {
            width: 50%;
            margin: auto;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 8px;
            background-color: #f9f9f9;
            margin-top: 20px;
        }

        .edit-container h2 {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="edit-container">
        <h2>Modifier Profil</h2>
        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>
        <form action="edit_profile.php" method="post" enctype="multipart/form-data" id="edit-profile-form">
            <div class="mb-3">
                <label for="Nom" class="form-label">Nom :</label>
                <input type="text" class="form-control" id="Nom" name="Nom" value="<?php echo htmlspecialchars($user['Nom']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="prenom" class="form-label">Prénom :</label>
                <input type="text" class="form-control" id="prenom" name="prenom" value="<?php echo htmlspecialchars($user['prenom']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="telephone" class="form-label">Téléphone :</label>
                <input type="text" class="form-control" id="telephone" name="telephone" value="<?php echo htmlspecialchars($user['telephone']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email :</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="fielere" class="form-label">Filière :</label>
                <input type="text" class="form-control" id="fielere" name="fielere" value="<?php echo htmlspecialchars($user['fielere']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="picture" class="form-label">Photo de profil :</label>
                <input type="file" class="form-control" id="picture" name="picture">
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Sauvegarder les modifications</button>
                <a href="profiladhrent.php" class="btn btn-secondary">Retour au profil</a>
            </div>
        </form>
    </div>
</body>
</html>
