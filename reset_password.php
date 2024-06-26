<?php
include_once("connexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password === $confirm_password) {
        // Mettre à jour le mot de passe dans la base de données
        $sql = "UPDATE Adherents SET pwd = :pwd WHERE email = :email";
        $stmt = $connexion->prepare($sql);
        $stmt->bindParam(':pwd', $password, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);

        if ($stmt->execute()) {
            // Rediriger vers la page de connexion avec un message de succès
            header("Location: loginadhrent.php?password_changed=true");
            exit();
        } else {
            $error_message = "Erreur lors de la mise à jour du mot de passe.";
        }
    } else {
        $error_message = "Les mots de passe ne correspondent pas.";
    }
} elseif (isset($_GET['email'])) {
    $email = $_GET['email']; // Obtenir l'email depuis le paramètre GET
} else {
    // Rediriger vers la page de mot de passe oublié si l'email n'est pas passé en paramètre
    header("Location: forgot_password.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Réinitialiser le mot de passe</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        form {
            margin-top: 20px;
        }
        label {
            font-weight: bold;
        }
        input[type="password"],
        button {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            box-sizing: border-box;
        }
        button {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Réinitialiser le mot de passe</h2>
        <form method="POST" action="reset_password.php">
            <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">
            <div class="mb-3">
                <label for="password" class="form-label">Nouveau mot de passe :</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirmer le mot de passe :</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
            </div>
            <?php if (isset($error_message)): ?>
                <div class="alert alert-danger"><?php echo $error_message; ?></div>
            <?php endif; ?>
            <button type="submit" class="btn btn-primary">Réinitialiser</button>
        </form>
    </div>
</body>
</html>
