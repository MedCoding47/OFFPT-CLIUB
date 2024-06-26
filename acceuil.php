<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Dish Site</title>
    <link rel="stylesheet" href="test.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <style>
        /* General styling */
        .club-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
        }
        .club-info {
            flex: 1;
            padding-right: 20px;
        }
        .club-image {
            flex: 1;
            text-align: center;
        }
        .club-image img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
        }
        .comment_section {
            margin-bottom: 10px;
           
    padding-bottom:600px; /* pour ajouter de l'espace en bas de chaque commentaire */
}


    
      
   
   
</style>
   
</head>
<body>
    
    <header>
        <div class="logo">
            <p><span>OFPPT</span>Club</p>
        </div>
        <ul class="menu">
            <li><a href="#home">Acceuil</a></li>
            <li><a href="activities.php">activities</a></li>
            <li><a href="profiladhrent.php">members</a></li>
            <li><a href="welcome.php">Admin</a></li>
        </ul>

        <!-- menu responsive -->
        <div class="toggle_menu"></div>
    </header>

    <!-- section acceuil home -->

    <section id="home">
        <div class="left">
            <h4>Discover Your Passions and Join the Fun!</h4>
            <h1> In Ofppt Club Hub!</h1>
            <p>Join the excitement and unleash your potential by becoming a part of our vibrant club community. From competitive sports teams to creative arts groups.</p>
            <button><a href="ajout_adherent.php">Join Now</a></button>
        </div>
        <div class="right">
            <img src="pics/888.jpg">
        </div>
    </section>

    <!-- section  menu -->

    <section id="menu">
    <h4 class="mini_title">Our Events</h4>
    <h2 class="title">Upcoming Events</h2>
    <div class="dishes">
        <?php
        include_once("connexion.php");
        $query = "SELECT e.code, c.libelle AS ClubName, e.nom_event, e.jourP, e.DateR, e.Observation, e.picture_path
                  FROM Evenements e
                  INNER JOIN Club c ON e.CodeClub = c.CodeClub";
        $pdostmt = $connexion->prepare($query);
        $pdostmt->execute();
        while ($ligne = $pdostmt->fetch(PDO::FETCH_ASSOC)):
        ?>
        <div class="dish">
            <?php if (!empty($ligne["picture_path"])): ?>
                <img src="<?php echo $ligne["picture_path"]; ?>" alt="Event Image">
            <?php else: ?>
                <img src="images/default_event_image.png" alt="Default Event Image"> <!-- Default image if no picture available -->
            <?php endif; ?>
            <h2><?php echo $ligne["nom_event"]; ?></h2> <!-- Display the event name -->
            <p><?php echo $ligne["ClubName"]; ?></p>
            <!-- You can add more event details here if needed -->
            <a href="more.php?code=<?php echo $ligne['code']; ?>">More</a>
        </div>
        <?php endwhile; ?>
    </div>
</section>

    <!-- section about us -->

    <section id="about_us">
        <h4 class="mini_title">About Us</h4>
        <h2 class="title">Why choose us ?</h2>
        <div class="club-section" id="clubSection">
            <div class="club-info" id="clubInfo">
                <!-- Club details will be injected here by JavaScript -->
            </div>
            <div class="club-image" id="clubImage">
                <!-- Club image will be injected here by JavaScript -->
            </div>
        </div>
    </section>
    <script src="clubs.js"></script>

    <!-- section comments -->
    <section class="comment_section">
    <h4 class="mini_title">Comments</h4>
    <h2 class="title"> What People Think About Us</h2>
    <div class="comments">
        <?php
        $query_reviews = "SELECT r.review, a.nom, a.prenom 
                          FROM Reviews r 
                          INNER JOIN Adherents a ON r.CodeAdhrents = a.CodeAdhrents 
                          ORDER BY r.id DESC";
        $stmt_reviews = $connexion->prepare($query_reviews);
        $stmt_reviews->execute();
        $reviews = $stmt_reviews->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <?php if (!empty($reviews)): ?>
            <?php foreach ($reviews as $review): ?>
                <div class="comment">
                    <div>
                        <h4><?php echo htmlspecialchars($review['prenom']) . " " . htmlspecialchars($review['nom']); ?></h4>
                       
                    </div>
                    <p><?php echo htmlspecialchars($review['review']); ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No reviews yet. Be the first to review!</p>
        <?php endif; ?>
    </div>
    </section>

    

    <!-- footer -->
    <footer>
        <div class="services_list">
            <div class="service">
                
                <h2>Ouverture</h2>
                <p>10h30 à 23h45</p>
                <p>23h45 à 9h30</p>
            </div>
            <div class="service">
                <h2>Adresses</h2>
                <p>boulvard-far</p>
                <p>ISGI</p>
            </div>
            <div class="service">
                <h2>Emails</h2>
                <p>ISGI-CLUV@gmail.com</p>
                <p>your.dish@gmail.com</p>
            </div>
            <div class="service">
                <h2>Numbers</h2>
                <p>+33 54454544</p>
                <p>+33 45687515</p>
            </div>
            <hr>
        </div>
        <p class="footer_text">Réalisé par <span>Mohamed ayat</span> | Tous les droits sont réservés.</p>
    </footer>

    
</body>
</html>
