<!DOCTYPE html>
<html>
<head>
    <title>Inscription</title>
    <!-- Add necessary CSS and JavaScript if required -->
</head>
<body>
    <h1>Inscription</h1>
    <div class="container">
        <form method="post" action="login.php">
            <div class="mb-3 mt-3">
                <label for="CodeEleve" class="form-label">CodeEleve :</label><br>
                <input type="number" class="form-control" id="CodeEleve" placeholder="Entrez l'identifiant" name="CodeEleve">
            </div>
            <div class="mb-3">
                <label for="pwd" class="form-label">Mot de passe :</label><br>
                <input type="password" class="form-control" id="pwd" placeholder="Entrez le mot de passe" name="pwd">
            </div>
            <input type="submit" value="S'inscrire" class="btn btn-info">
        </form>
    </div>
</body>
<?php

include_once("connexion.php");

if (!empty($_POST["CodeEleve"]) && !empty($_POST["pwd"])) {
    // Prepare and execute SQL query to insert user's credentials into the database
    $query = "INSERT INTO respo (CodeEleve, pwd) VALUES (:CodeEleve, :pwd)";
    $pdostmt = $connexion->prepare($query);
    $pdostmt->execute(["CodeEleve" => $_POST["CodeEleve"], "pwd" => $_POST["pwd"]]);

    // Redirect the user to the login page after successful registration
    header("Location:login.php");
    exit();
} else {
    // Handle empty form fields
    echo "Veuillez remplir tous les champs.";
}
?>

</html>
