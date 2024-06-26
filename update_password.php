<?php
include_once("connexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token = $_POST['token'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password === $confirm_password) {
        // Find the token in the database
        $sql = "SELECT email, expires FROM password_resets WHERE token = :token";
        $stmt = $connexion->prepare($sql);
        $stmt->bindParam(':token', $token, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $email = $row['email'];
            $expires = $row['expires'];

            // Check if the token has expired
            if (new DateTime() > new DateTime($expires)) {
                echo "Le lien de réinitialisation a expiré.";
                exit();
            }

            // Update the password in the adherents table
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $sql = "UPDATE Adherents SET pwd = :pwd WHERE email = :email";
            $stmt = $connexion->prepare($sql);
            $stmt->bindParam(':pwd', $hashed_password, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();

            // Delete the token from the database
            $sql = "DELETE FROM password_resets WHERE token = :token";
            $stmt = $connexion->prepare($sql);
            $stmt->bindParam(':token', $token, PDO::PARAM_STR);
            $stmt->execute();

            echo "Votre mot de passe a été réinitialisé avec succès.";
            header("Location: loginadherent.php");
            exit();
        } else {
            echo "Token invalide.";
        }
    } else {
        echo "Les mots de passe ne correspondent pas.";
    }
}
?>
