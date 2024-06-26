<?php
include_once("connexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $nomadhrent = $_POST["nomadhrent"];
    $fielere = $_POST["fielere"];
    $codeClub = $_POST["codeClub"];

    $query = "
        UPDATE Adherents 
        SET Nomadhrent = :nomadhrent, fielere = :fielere, CodeClub = :codeClub
        WHERE CodeStagiaire = :id
    ";
    $pdostmt = $connexion->prepare($query);
    $pdostmt->bindParam(':nomadhrent', $nomadhrent);
    $pdostmt->bindParam(':fielere', $fielere);
    $pdostmt->bindParam(':codeClub', $codeClub);
    $pdostmt->bindParam(':id', $id);
    $pdostmt->execute();

    header("Location: liste_adherents.php");
    exit();
}

$id = $_GET["id"];
$query = "
    SELECT A.CodeStagiaire, A.Nomadhrent, A.fielere, A.CodeClub, C.Libelle 
    FROM Adherents A
    JOIN Club C ON A.CodeClub = C.CodeClub
    WHERE A.CodeStagiaire = :id
";
$pdostmt = $connexion->prepare($query);
$pdostmt->bindParam(':id', $id);
$pdostmt->execute();
$adherent = $pdostmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Modifier Adhérent</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link rel="stylesheet" href="test.css" />
</head>
<body>
<div class="container">
    <h1 class="mt-5">Modifier Adhérent</h1>
    <form method="post" >
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($adherent["CodeStagiaire"]); ?>" />
        <div class="mb-3">
            <label for="nomadhrent" class="form-label">Nom Adhérent</label>
            <input type="text" class="form-control" id="nomadhrent" name="nomadhrent" value="<?php echo htmlspecialchars($adherent["Nomadhrent"]); ?>" required>
        </div>
        <div class="mb-3">
            <label for="fielere" class="form-label">Filière</label>
            <input type="text" class="form-control" id="fielere" name="fielere" placeholder="Entrez fielere" value="<?php echo htmlspecialchars($adherent["fielere"]); ?>" required>
        </div>
        <div class="mb-3">
            <label for="codeClub" class="form-label">Code Club</label>
            <input type="text" class="form-control" id="codeClub" name="codeClub" value="<?php echo htmlspecialchars($adherent["CodeClub"]); ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Modifier</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gybBogGzGUN52RZhXvVxgqPjCIOCkzNk5aKeDk5IY63KEeBFNh" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js" integrity="sha384-czSH6gZa5q7u5O1zHl8z8wvJd3g7cDkHxXpuOERzIgGHRhXZBp8fka/rrFzMOfpK" crossorigin="anonymous"></script>
</body>
</html>
