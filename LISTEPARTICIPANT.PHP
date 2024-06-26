<?php
// Inclure le fichier de connexion à la base de données
include_once("connexion.php");

// Requête pour récupérer les événements et les adhérents qui y ont participé
$sql = "SELECT Evenements.nom_event AS EventName, Evenements.Description AS EventDescription, 
        GROUP_CONCAT(CONCAT(Adherents.Nom, ' ', Adherents.prenom) SEPARATOR ', ') AS Participants
        FROM Evenements
        LEFT JOIN EventParticipants ON Evenements.code = EventParticipants.event_id
        LEFT JOIN Adherents ON EventParticipants.CodeAdhrents = Adherents.CodeAdhrents
        GROUP BY Evenements.nom_event, Evenements.Description
        ORDER BY Evenements.nom_event";
$stmt = $connexion->prepare($sql);
$stmt->execute();
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Liste des Événements et Participants</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table-container {
            margin-top: 20px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table th, .table td {
            border: 1px solid #dee2e6;
            padding: 8px;
            text-align: left;
        }
        .table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Liste des Événements et Participants</h1>
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nom de l'Événement</th>
                      
                        <th>Participants</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($events as $event): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($event['EventName']); ?></td>
                     
                            <td><?php echo htmlspecialchars($event['Participants']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
