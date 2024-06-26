<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="ajouter_produit.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

    <!-- L'entête -->


    <header >
        <div class="logo">
            <a href="index.html"><img src="images_index/logo.JPG" alt="Logo de la parapharmacie" width="300px" height="100px"  ></a>
        </div>
        <div class="centre">
            <h1 class="parapharmacie-title">VOTRE PARAPHARMACIE EN LIGNE À PETIT PRIX !</h1>
        </div>

        <div class="partie_gauche_haut">
            <a href="#" style="margin-right: 15px;"><i class="fas fa-key" style="font-size: 24px;"></i>S'identifier</a>
            <a href="#" ><i class="fas fa-envelope" style="font-size: 24px;"></i>Nous contacter</a>
        </div>
        
    </header>

<body>    

<div class="container">
        <h2>Ajouter un produit</h2>
        <form action="ajouter_produit.php" method="post" enctype="multipart/form-data">
            <label for="categorie">Catégorie :</label>
            <select id="categorie" name="categorie" required>
                <option value="produits_beaute">produits_beaute</option>
                <option value="produits_hygiene">produits_hygiene</option>
                <option value="produits_sante">produits_sante</option>
                <option value="produits_bebe">produits_bebe</option>
                <option value="produits_complements">produits_complements</option>


                <!-- Ajoutez d'autres catégories selon vos besoins -->
            </select>
            
            <label for="nom">Nom du produit :</label>
            <input type="text" id="nom" name="nom" required>
            
            <label for="description">Description :</label>
            <textarea id="description" name="description" rows="4" required></textarea>
            
            <label for="prix">Prix :</label>
            <input type="number" id="prix" name="prix" min="0" step="0.01" required>
            
            <label for="quantite">Quantité en stock :</label>
            <input type="number" id="quantite" name="quantite" min="0" required>
            
            <label for="image">Image :</label>
            <input type="file" id="image" name="image" accept="image/*" required>
            
            <input type="submit" value="Ajouter le produit">
        </form>
    </div>
    



</body>

<?php
include 'connexion.php';

// Récupération des données du formulaire
$categorie = isset($_POST['categorie']) ? $_POST['categorie'] : '';
$nom = isset($_POST['nom']) ? $_POST['nom'] : '';
$description = isset($_POST['description']) ? $_POST['description'] : '';
$prix = isset($_POST['prix']) ? $_POST['prix'] : '';
$quantite = isset($_POST['quantite']) ? $_POST['quantite'] : '';

// Vérification des données du formulaire
if(empty($categorie) || empty($nom) || empty($description) || empty($prix) || empty($quantite)) {
    die("Veuillez remplir tous les champs du formulaire.");
}

// Vérification de l'existence et du contenu du fichier image
if(!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
    die("Une erreur est survenue lors du téléchargement de l'image.");
}

// Vérification de la connexion à la base de données
if(!$conn) {
    die("Erreur de connexion à la base de données : ");
}

// Chemin complet vers le fichier image
$image = "images_ajoutées/" . $_FILES['image']['name'];

// Déplacement de l'image vers un dossier sur le serveur
$target_dir = "images_ajoutées/";
$target_file = $target_dir . basename($_FILES["image"]["name"]);

if(!move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
    die("Erreur lors du déplacement du fichier téléchargé.");
}

try {
    $sql = "INSERT INTO $categorie (Nom, Description, Prix, QuantiteEnStock, ImageURL) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$nom, $description, $prix, $quantite, $image]);
    
    if($stmt->rowCount() > 0) {
        echo "Produit ajouté avec succès.";
        header("Location: admin.php");
    } else {
        echo "Aucun produit n'a été ajouté.";
    }
} catch (PDOException $e) {
    echo "Erreur lors de l'ajout du produit : " . $e->getMessage();
}

$conn = null;
?>
<br><br><br><br><br><br><br><br><br><br>
<br><br><br><br><br><br><br><br><br><br>
<br><br><br><br><br><br><br><br><br><br>
<footer>
    <div class="footer">

        <div class="footer-section">
            <h3>À propos de nous</h3>
            <p>Nous sommes une compagnie parapharmaceutique engagée dans la santé et le bien-être de nos clients.</p>
            <p>Notre mission est de fournir des produits de qualité et des conseils professionnels.</p>
        </div>


        <div class="footer-section">
            <h3>Liens utiles</h3>
            <a href="#">Accueil</a>
            <a href="#">Produits</a>
            <a href="#">Conseils</a>
            <a href="#">Promotions</a>
        </div>


        <div class="footer-section">
            <h3>Contact</h3>
            <p>Téléphone : +33 1 23 45 67 89</p>
            <p>Email : contact@parapharmacie.com</p>
            <p>Adresse : 123 Rue de la Santé, 75000 Paris</p>
        </div>


        <div class="footer-section">
            <h3>Suivez-nous</h3>
            <a href="#">Facebook</a>
            <a href="#">Twitter</a>
            <a href="#">Instagram</a>
            <a href="#">LinkedIn</a>
        </div>
    </div>
</footer>
</html>