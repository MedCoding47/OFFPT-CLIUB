<?php
session_start();
include_once("connexion.php");

if (!isset($_SESSION['CodeAdhrents'])) {
    header("Location: loginadhrent.php");
    exit();
}

// Function to generate a random CAPTCHA code
function generateCaptchaCode($length = 6) {
    $characters = '0123456789';
    $captchaCode = '';
    for ($i = 0; $i < $length; $i++) {
        $captchaCode .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $captchaCode;
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_delete'])) {
    // Validate CAPTCHA code
    if ($_POST['captcha'] === $_SESSION['captcha_code']) {
        // CAPTCHA code is correct
        $user_id = $_SESSION['CodeAdhrents'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Validate email and password
        $sql_validate = "SELECT * FROM Adherents WHERE CodeAdhrents = :user_id AND email = :email AND pwd = :pwd";
        $stmt_validate = $connexion->prepare($sql_validate);
        $stmt_validate->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt_validate->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt_validate->bindParam(':pwd', $password, PDO::PARAM_STR);
        $stmt_validate->execute();

        if ($stmt_validate->rowCount() > 0) {
            // Begin transaction
            $connexion->beginTransaction();

            try {
                // Delete from EventParticipants
                $sql_delete_participants = "DELETE FROM EventParticipants WHERE CodeAdhrents = :user_id";
                $stmt_delete_participants = $connexion->prepare($sql_delete_participants);
                $stmt_delete_participants->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                $stmt_delete_participants->execute();

                // Delete from Adherents
                $sql_delete_adherents = "DELETE FROM Adherents WHERE CodeAdhrents = :user_id";
                $stmt_delete_adherents = $connexion->prepare($sql_delete_adherents);
                $stmt_delete_adherents->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                $stmt_delete_adherents->execute();

                // Commit transaction
                $connexion->commit();

                // Account deleted successfully, redirect to login page with success message
                header("Location: loginadhrent.php?account_deleted=true");
                exit();
            } catch (Exception $e) {
                // Rollback transaction if something went wrong
                $connexion->rollBack();
                $_SESSION['error_message'] = "Une erreur s'est produite lors de la suppression du compte : " . $e->getMessage();
                header("Location: delete_account.php");
                exit();
            }
        } else {
            $_SESSION['error_message'] = "Email ou mot de passe incorrect.";
            header("Location: delete_account.php");
            exit();
        }
    } else {
        // CAPTCHA code is incorrect
        $_SESSION['error_message'] = "Le code CAPTCHA est incorrect.";
        header("Location: delete_account.php");
        exit();
    }
}

// Generate and store CAPTCHA code in session
$_SESSION['captcha_code'] = generateCaptchaCode();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Supprimer le compte</title>
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
        input[type="password"],
        input[type="text"],
        button {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            box-sizing: border-box;
        }
        button {
            background-color: #dc3545;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        button:hover {
            background-color: #c82333;
        }
        .captcha-container {
            margin-bottom: 20px;
        }
        .captcha-digit {
            display: inline-block;
            font-size: 20px;
            font-weight: bold;
            margin-right: 5px;
            padding: 5px 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Supprimer mon compte</h2>
        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="alert alert-danger">
                <?php echo htmlspecialchars($_SESSION['error_message']); ?>
            </div>
            <?php unset($_SESSION['error_message']); ?>
        <?php endif; ?>
        <p>Entrez votre email, mot de passe et le code CAPTCHA pour confirmer la suppression de votre compte.</p>
        <form method="post">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="captcha-container">
                <label for="captcha" class="form-label">Code CAPTCHA</label>
                <?php foreach (str_split($_SESSION['captcha_code']) as $digit): ?>
                    <span class="captcha-digit"><?php echo $digit; ?></span>
                <?php endforeach; ?>
            </div>
            <input type="text" class="form-control" id="captcha" name="captcha" placeholder="Entrez le code CAPTCHA" required>
            <button type="submit" name="confirm_delete" class="btn btn-danger">Confirmer la suppression</button>
        </form>
    </div>
</body>
</html>
