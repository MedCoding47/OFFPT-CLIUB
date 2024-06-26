<!DOCTYPE html>
<html>
<head>
    <title>Login pour Participer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <style>
        form{
            width: 400px;
        }
        h1{
            padding-left: 500px;
        }
        h1 span {
            color: aqua;
        }
        .container{
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>
<body>
    <h1><span>A</span>uthentification pour Participer</h1>
    <div class="container">
        <form method="post">
            <div class="mb-3 mt-3">
                <label for="email" class="form-label">Email :</label><br>
                <input type="text" class="form-control" id="email" placeholder="Entrez email" name="email">
            </div>
            <div class="mb-3">
                <label for="pwd" class="form-label">Mot de passe :</label><br>
                <input type="password" class="form-control" id="pwd" placeholder="Entrez le mot de passe" name="pwd">
            </div>
            <div class="mt-3">
                <p>Vous n'avez pas de compte ? <a href="ajout_adherent.php">Inscrivez-vous ici</a></p>
            </div>
            <input type="submit" value="Se connecter" class="btn btn-info">
        </form>
    </div>
</body>

</html>
<?php
session_start();
include_once("connexion.php");

$error_message = ""; // Initialize an empty error message

if (!empty($_POST["email"]) && !empty($_POST["pwd"])) {
    $query = "SELECT * FROM Adherents WHERE email = :email AND pwd = :pwd";
    $pdostmt = $connexion->prepare($query);
    $pdostmt->execute(["email" => $_POST["email"], "pwd" => $_POST["pwd"]]);

    $Adherents = $pdostmt->fetch();
    $pdostmt->closeCursor();

    if ($Adherents) {
        if ($Adherents['valide']) {
            // Save user information in the session
            $_SESSION['CodeAdhrents'] = $Adherents['CodeAdhrents'];
            $_SESSION['Nom'] = $Adherents['Nom'];

            // Redirect to the original page or event participation page
            if (isset($_GET['redirect'])) {
                header("Location: " . urldecode($_GET['redirect']));
            } else {
                header("Location: profiladhrent.php");
            }
            exit();
        } else {
            // User is not validated
            $error_message = "Votre compte n'est pas encore validé. Veuillez contacter l'administrateur.";
            echo $error_message;
        }
    } else {
        // Incorrect identifier or password
        $error_message = "Identifiant ou mot de passe incorrect.";
        echo $error_message;
    }
}

// Ensure session ends when navigating back to acceuil.php
if (isset($_SESSION['CodeAdhrents'])) {
    session_destroy();
    header("Location: acceuil.php");
    exit();
}
?>
