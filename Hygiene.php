<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="Hygiene.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

    <!-- L'entête -->


    <header >
        <div class="logo">
            <a href="acceuil.php"><img src="images_index/logo.JPG" alt="Logo de la parapharmacie" width="300px" height="100px"  ></a>
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
<div class="contenu_central">

    <div class="liste_de_thèmes">
        <ul class="constituants">
            <li><a><i class="fa-solid fa-venus"></i> Beauté</a></li>

            <li><a><i class="fa-solid fa-hand-sparkles"></i> Hygiène</a></li>

            <li><a><i class="fa-solid fa-heart"></i> Santé</a></li>

            <li><a><i class="fa-solid fa-baby"></i> Bebe-mamans</a></li>

            <li><a><i class="fa-solid fa-egg"></i>Complements Alimentaires</a></li>
        </ul>
    </div>

    <div class="liste_produits">
            <?php
                include 'connexion.php';
                $sql = 'SELECT Nom, Description, Prix, QuantiteEnStock,ImageURL FROM produits_Hygiene';
                $stmt = $conn->query($sql);
                
                // Récupérer tous les résultats
                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                // Compter le nombre de résultats
                $numRows = count($results);
                if ($numRows > 0) {
                    foreach ($results as $row) {
                        echo'<div class="product-card">';
                        echo'<img src="' . $row['ImageURL'] . '" alt="Nom du produit" class="product-image">';
                        echo'<div class="product-name">' . $row['Nom'] . '</div>';
                        echo'<div class="product-description">';
                        echo'' . $row['Description'] . '';
                        echo'</div>';
                        echo'<div class="product-price">' . $row['Prix'] . 'DH</div>';
                        echo'<a href="#" class="add-to-cart-button">Ajouter au panier</a>';
                        echo'</div>';
                    }
                } else {
                    echo '<p>Aucun produit trouvé.</p>';
                }
        
                // Fermer la connexion à la base de données
                ?>

    </div>
    



</div>

</body>

<br><br><br><br><br><br><br><br><br><br>
<br><br><br><br><br><br><br><br><br><br>
<br><br><br><br><br><br><br><br><br><br>
<br><br><br><br><br><br><br><br><br><br>
<br><br><br><br><br><br><br><br><br><br>
<br><br><br><br><br><br><br><br><br><br>
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