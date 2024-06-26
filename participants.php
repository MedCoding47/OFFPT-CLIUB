<?php
include_once("connexion.php");

try {
    $query = "SELECT e.Libelle AS event_name, e.DateEvent AS event_date, a.Nom, ep.payment_status
              FROM EventParticipants ep
              INNER JOIN Evenements e ON ep.event_id = e.Code
              INNER JOIN Adherents a ON ep.CodeAdhrents = a.CodeAdhrents";
    $pdostmt = $connexion->prepare($query);
    $pdostmt->execute();
    $participants = $pdostmt->fetchAll(PDO::FETCH_ASSOC);

    if ($participants) {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Participants and Events</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f9f9f9;
                    margin: 0;
                    padding: 0;
                }
                .container {
                    max-width: 800px;
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
                .participant {
                    display: flex;
                    justify-content: space-between;
                    padding: 10px 0;
                    border-bottom: 1px solid #ccc;
                }
                .participant:last-child {
                    border-bottom: none;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <h1>Participants and Events</h1>
                <?php foreach ($participants as $participant): ?>
                    <div class="participant">
                        <div>
                            <strong>Participant:</strong> <?php echo htmlspecialchars($participant['Nom']); ?><br>
                            <strong>Event:</strong> <?php echo htmlspecialchars($participant['event_name']); ?><br>
                            <strong>Date:</strong> <?php echo htmlspecialchars($participant['event_date']); ?>
                        </div>
                        <div>
                            <strong>Payment Status:</strong> <?php echo htmlspecialchars($participant['payment_status']); ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </body>
        </html>
        <?php
    } else {
        echo "No participants found.";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
