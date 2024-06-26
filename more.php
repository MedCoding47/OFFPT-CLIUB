<?php
session_start();
include_once("connexion.php");

$isAdherentLoggedIn = isset($_SESSION['adherent_logged_in']) && $_SESSION['adherent_logged_in'];

if (isset($_GET['code'])) {
    $code = intval($_GET['code']);
    $query = "SELECT e.code, c.libelle AS ClubName, e.nom_event, e.jourP, e.DateR, e.Description, e.Observation, e.picture_path
              FROM Evenements e
              INNER JOIN Club c ON e.CodeClub = c.CodeClub
              WHERE e.code = :code";
    $pdostmt = $connexion->prepare($query);
    $pdostmt->bindParam(':code', $code, PDO::PARAM_INT);
    $pdostmt->execute();
    $event = $pdostmt->fetch(PDO::FETCH_ASSOC);

    // Fetch reviews for the event
    $query_reviews = "SELECT r.review, a.nom, a.prenom 
                      FROM Reviews r 
                      INNER JOIN Adherents a ON r.CodeAdhrents = a.CodeAdhrents 
                      WHERE r.event_code = :code";
    $stmt_reviews = $connexion->prepare($query_reviews);
    $stmt_reviews->bindParam(':code', $code, PDO::PARAM_INT);
    $stmt_reviews->execute();
    $reviews = $stmt_reviews->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Details</title>
    <link rel="stylesheet" href="test.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f8f8;
            margin-top: 50px;
        }
        main {
            padding: 2rem;
            display: flex;
            justify-content: center;
        }
        .event-details {
            background-color: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 1000px;
            width: 100%;
            display: flex;
            flex-direction: row;
        }
        .event-details .left {
            flex: 1;
            padding-right: 2rem;
            border-right: 1px solid #ddd;
        }
        .event-details .left img {
            width: 100%;
            height: auto;
            border-radius: 5px;
        }
        .event-details .left .info {
            margin-top: 1rem;
        }
        .event-details .left .info div {
            margin-bottom: 1rem;
        }
        .event-details .left .info h3 {
            margin: 0;
            font-size: 1.1rem;
            color: #555;
        }
        .event-details .left .info p {
            margin: 0;
            font-size: 1rem;
            color: #666;
        }
        .event-details .right {
            flex: 2;
            padding-left: 2rem;
        }
        .event-details .right h2 {
            margin-top: 0;
            font-size: 2rem;
            color: #333;
        }
        .event-details .right p {
            font-size: 1rem;
            color: #666;
            line-height: 1.5;
            margin-top: 1rem;
        }
        .review-button {
            margin-top: 2rem;
            text-align: center;
        }
        .review-button button {
            background-color: #007bff;
            color: white;
            padding: 1rem 2rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
        }
        .review-button button:hover {
            background-color: #0056b3;
        }
        .comment_section {
            margin-top: 3rem;
        }
        .comment_section .mini_title {
            font-size: 1.2rem;
            color: #007bff;
            margin-bottom: 1rem;
        }
        .comment_section .title {
            font-size: 1.5rem;
            color: #333;
            margin-bottom: 2rem;
        }
        .comments {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }
        .comment {
            background-color: #f9f9f9;
            padding: 1rem;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }
        .comment div {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .comment img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
        }
        .comment h4 {
            margin: 0;
            font-size: 1rem;
            color: #555;
        }
        .comment p {
            margin: 0.5rem 0 0;
            font-size: 1rem;
            color: #666;
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">
            <p><span>Event</span> Information</p>
        </div>
        <ul class="menu">
            <li><a href="acceuil.php">Acceuil</a></li>
            <li><a href="#menu">Menu</a></li>
            <li><a href="profiladhrent.php">Members</a></li>
            <li><a href="welcome.php">Admin</a></li>
        </ul>
    </header>

    <main>
        <?php if ($event): ?>
            <div class="event-details">
                <div class="left">
                    <?php if (!empty($event["picture_path"])): ?>
                        <img src="<?php echo $event["picture_path"]; ?>" alt="Event Image">
                    <?php else: ?>
                        <img src="images/default_event_image.png" alt="Default Event Image">
                    <?php endif; ?>
                    <div class="info">
                        <div>
                            <h3>Club</h3>
                            <p><?php echo $event["ClubName"]; ?></p>
                        </div>
                        <div>
                            <h3>Event Name</h3>
                            <p><?php echo $event["nom_event"]; ?></p>
                        </div>
                        <div>
                            <h3>Event Date</h3>
                            <p><?php echo $event["jourP"]; ?></p>
                        </div>
                        <div>
                            <h3>Reservation Date</h3>
                            <p><?php echo $event["DateR"]; ?></p>
                        </div>
                    </div>
                </div>
                <div class="right">
                    <h2><?php echo $event["Observation"]; ?></h2>
                    <p><?php echo $event["Description"]; ?></p>
                    
                    <div class="review-button">
                        <button onclick="location.href='add_review.php?event_code=<?php echo $event['code']; ?>'">Add Your Review</button>
                    </div>
                    
                </div>
            </div>
        <?php else: ?>
            <p>Event not found.</p>
        <?php endif; ?>
    </main>
</body>
</html>
