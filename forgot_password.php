<?php
include_once("connexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Vérifiez si l'email existe dans la base de données
    $sql = "SELECT * FROM Adherents WHERE email = :email";
    $stmt = $connexion->prepare($sql);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        // Rediriger vers la page de réinitialisation du mot de passe
        header("Location: reset_password.php?email=" . urlencode($email));
        exit();
    } else {
        $error_message = "L'email n'existe pas.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Mot de passe oublié</title>
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
        input[type="email"],
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
        <h2>Mot de passe oublié</h2>
        <form method="POST" action="forgot_password.php">
            <div class="mb-3">
                <label for="email" class="form-label">Email :</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <?php if (isset($error_message)): ?>
                <div class="alert alert-danger"><?php echo $error_message; ?></div>
            <?php endif; ?>
            <button type="submit" class="btn btn-primary">Soumettre</button>
        </form>
    </div>
</body>
</html>
