<?php
session_start();
include_once("connexion.php");

if (!isset($_SESSION['CodeAdhrents'])) {
    // Redirect to participation login page if not logged in
    header('Location: participelogin.php?redirect=' . urlencode($_SERVER['REQUEST_URI']));
    exit();
}

if (isset($_GET['event_id'])) {
    $event_id = $_GET['event_id'];

    // Fetch event details and payment info
    $query = "SELECT e.code, c.libelle AS ClubName, p.prix
              FROM Evenements e
              INNER JOIN Club c ON e.CodeClub = c.CodeClub
              LEFT JOIN Paiements p ON c.CodeClub = p.CodeClub
              WHERE e.code = :event_id";
    $pdostmt = $connexion->prepare($query);
    $pdostmt->execute(['event_id' => $event_id]);
    $event = $pdostmt->fetch(PDO::FETCH_ASSOC);

    if ($event) {
        // Show confirmation and payment page
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Confirmer l'inscription</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f9f9f9;
                    margin: 0;
                    padding: 0;
                }
                .container {
                    max-width: 600px;
                    margin: 50px auto;
                    padding: 20px;
                    background-color: #fff;
                    border-radius: 8px;
                    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                }
                h1 {
                    text-align: center;
                    margin-bottom: 20px;
                }
                .btn {
                    display: inline-block;
                    padding: 10px 20px;
                    background-color: #007bff;
                    color: #fff;
                    text-decoration: none;
                    border-radius: 4px;
                    transition: background-color 0.3s ease;
                    text-align: center;
                }
                .btn:hover {
                    background-color: #0056b3;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <h1>Confirmer l'inscription</h1>
                <p>Club: <?php echo htmlspecialchars($event['ClubName']); ?></p>
                <p>Code de l'événement: <?php echo htmlspecialchars($event['code']); ?></p>
                <p>Prix: <?php echo htmlspecialchars($event['prix']); ?> 100 €</p>
                <form action="payment_process.php" method="post">
                    <input type="hidden" name="event_id" value="<?php echo htmlspecialchars($event_id); ?>">
                    <input type="submit" value="Payer et Confirmer" class="btn">
                </form>
            </div>
        </body>
        </html>
        <?php
    } else {
        echo "Event not found.";
        // Debugging: display fetched event data
        var_dump($pdostmt->fetchAll(PDO::FETCH_ASSOC));
    }
} else {
    echo "Invalid request.";
}
?>
