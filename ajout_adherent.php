<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <title>Ajouter Adhérents</title>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 600px;
            margin-top: 50px;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
            margin-bottom: 20px;
            color: #007bff;
            text-align: center;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        .form-label {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Inscription Adhérent</h2>
        <form action="ajout_adherent.php" method="POST">
            <div class="mb-3">
                <label for="nom" class="form-label">Nom :</label>
                <input type="text" class="form-control" id="nom" name="nom" required>
            </div>
            <div class="mb-3">
                <label for="prenom" class="form-label">Prénom :</label>
                <input type="text" class="form-control" id="prenom" name="prenom" required>
            </div>
            <div class="mb-3">
                <label for="telephone" class="form-label">Téléphone :</label>
                <input type="text" class="form-control" id="telephone" name="telephone" required>
            </div>
            <div class="mb-3">
                <label for="pwd" class="form-label">Mot de passe :</label>
                <input type="password" class="form-control" id="pwd" name="pwd" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email :</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="filiere" class="form-label">Filière :</label>
                <input type="text" class="form-control" id="filiere" name="filiere" required>
            </div>
            <div class="mb-3">
                <label for="codeClub" class="form-label">Choisir un Club :</label>
                <select class="form-select" id="codeClub" name="codeClub" required>
                    <?php
                    include_once("connexion.php");
                    // Récupérer la liste des clubs depuis la base de données
                    $sql = "SELECT CodeClub, Libelle FROM Club";
                    $stmt = $connexion->prepare($sql);
                    $stmt->execute();
                    $clubs = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    // Générer les options de la liste déroulante
                    foreach ($clubs as $club) {
                        echo "<option value='{$club['CodeClub']}'>{$club['Libelle']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">S'inscrire</button>
                <button type="reset" class="btn btn-secondary">Réinitialiser</button>
                
            </div>
        </form>
    </div>

    <?php
    include_once("connexion.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $telephone = $_POST['telephone'];
        $pwd = $_POST['pwd'];
        $email = $_POST['email'];
        $filiere = $_POST['filiere'];
        $valide = False;
        $codeClub = $_POST['codeClub'];

        try {
            $sql = "INSERT INTO Adherents (CodeClub, Nom, prenom, telephone, pwd, email, fielere, valide) 
                    VALUES (:codeClub, :nom, :prenom, :telephone, :pwd, :email, :filiere, :valide)";
            
            $stmt = $connexion->prepare($sql);
            
            $stmt->bindParam(':codeClub', $codeClub, PDO::PARAM_INT);
            $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
            $stmt->bindParam(':prenom', $prenom, PDO::PARAM_STR);
            $stmt->bindParam(':telephone', $telephone, PDO::PARAM_STR);
            $stmt->bindParam(':pwd', $pwd, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':valide', $valide, PDO::PARAM_BOOL); // Use PDO::PARAM_BOOL for boolean
            $stmt->bindParam(':filiere', $filiere, PDO::PARAM_STR);

            if ($stmt->execute()) {
                echo 'enregistré avec succès';
                header("Location: loginadhrent.php");
                exit();
            } else {
                echo "Erreur lors de l'enregistrement de l'adhérent.";
            }
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    } else {
        echo "Les données du formulaire ne sont pas présentes.";
    }
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3BF0XUYXK4A/vyyaX/ZdA6+Wj/qnY1dFVmsMSzQJpfIdYyIIjycW9ApyH3iKnQJ" crossorigin="anonymous"></script>
</body>
</html>
