<?php
include_once("connexion.php");

// Vérifie si l'identifiant de l'adhérent est passé en paramètre
if(isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Requête pour récupérer les informations de l'adhérent à modifier
    $query = "SELECT * FROM Adherents WHERE CodeAdhrents = :id";
    $pdostmt = $connexion->prepare($query);
    $pdostmt->bindParam(':id', $id);
    $pdostmt->execute();
    
    // Vérifie si l'adhérent existe dans la base de données
    if($pdostmt->rowCount() > 0) {
        $adhérent = $pdostmt->fetch(PDO::FETCH_ASSOC);
    } else {
        // Redirection si l'adhérent n'est pas trouvé
        header("Location: liste_adherents.php");
        exit;
    }
} else {
    // Redirection si l'identifiant n'est pas passé en paramètre
    header("Location: liste_adherents.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Modifier Adhérent</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <h1 class="mt-5">Modifier Adhérent</h1>
        <form action="traitement_modification.php" method="post">
            <input type="hidden" name="id" value="<?php echo $adhérent['CodeAdhrents']; ?>">
            <div class="mb-3">
                <label for="nom" class="form-label">Nom</label>
                <input type="text" class="form-control" id="nom" name="nom" value="<?php echo $adhérent['Nom']; ?>">
            </div>
            
            <!-- Ajoutez d'autres champs ici pour les autres informations de l'adhérent -->
            <button type="submit" class="btn btn-primary">Enregistrer</button>
        </form>
    </div>
</body>

</html>
