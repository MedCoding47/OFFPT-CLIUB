<?php
session_start();
include_once("connexion.php");

// Check if the user is logged in
if (!isset($_SESSION['CodeAdhrents'])) {
    header("Location: loginadhrent.php");
    exit();
}

$user_id = $_SESSION['CodeAdhrents'];

// Debug: Check user ID from session
error_log("User ID from session: " . $user_id);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if (!empty($current_password) && !empty($new_password) && !empty($confirm_password)) {
        if ($new_password === $confirm_password) {
            try {
                // Debug: Check if the query is correct
                $sql_password = "SELECT password FROM Adherents WHERE CodeAdhrents = :user_id";
                error_log("SQL Query: " . $sql_password);

                $stmt_password = $connexion->prepare($sql_password);
                $stmt_password->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                $stmt_password->execute();
                $result = $stmt_password->fetch(PDO::FETCH_ASSOC);

                // Debug: Check if result is fetched
                error_log("Fetch result: " . json_encode($result));

                if ($result) {
                    if (password_verify($current_password, $result['password'])) {
                        $new_password_hashed = password_hash($new_password, PASSWORD_DEFAULT);
                        $sql_update_password = "UPDATE Adherents SET password = :new_password WHERE CodeAdhrents = :user_id";
                        $stmt_update_password = $connexion->prepare($sql_update_password);
                        $stmt_update_password->bindParam(':new_password', $new_password_hashed);
                        $stmt_update_password->bindParam(':user_id', $user_id, PDO::PARAM_INT);

                        if ($stmt_update_password->execute()) {
                            header("Location: profiladhrent.php");
                            exit();
                        } else {
                            $error_message = "Une erreur s'est produite lors de la mise à jour du mot de passe.";
                        }
                    } else {
                        $error_message = "Le mot de passe actuel est incorrect.";
                    }
                } else {
                    $error_message = "Utilisateur introuvable.";
                }
            } catch (PDOException $e) {
                $error_message = "Erreur d'exécution de la requête: " . $e->getMessage();
            }
        } else {
            $error_message = "Les nouveaux mots de passe ne correspondent pas.";
        }
    } else {
        $error_message = "Tous les champs sont obligatoires.";
    }
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Changer le mot de passe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <style>
        .password-container {
            width: 50%;
            margin: auto;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 8px;
            background-color: #f9f9f9;
            margin-top: 20px;
        }

        .password-container h2 {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="password-container">
        <h2>Changer le mot de passe</h2>
        <?php if (isset($error_message) && !empty($error_message)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>
        <form action="changepassword.php" method="post">
            <div class="mb-3">
                <label for="current_password" class="form-label">Mot de passe actuel :</label>
                <input type="password" class="form-control" id="current_password" name="current_password" required>
            </div>
            <div class="mb-3">
                <label for="new_password" class="form-label">Nouveau mot de passe :</label>
                <input type="password" class="form-control" id="new_password" name="new_password" required>
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirmer le nouveau mot de passe :</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Changer le mot de passe</button>
                <a href="profiladhrent.php" class="btn btn-secondary">Retour au profil</a>
            </div>
        </form>
    </div>
</body>
</html>
