<?php
// Inclure le fichier de connexion à la base de données
include_once("connexion.php");

// Requête pour récupérer tous les clubs et leurs adhérents
$sql = "SELECT Club.Libelle AS ClubLibelle, GROUP_CONCAT(CONCAT(Adherents.Nom, ' ', Adherents.prenom) SEPARATOR ', ') AS Adherents
        FROM Club
        LEFT JOIN Adherents ON Club.CodeClub = Adherents.CodeClub
        GROUP BY Club.Libelle
        ORDER BY Club.Libelle";
$stmt = $connexion->prepare($sql);
$stmt->execute();
$clubs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Liste des Clubs et Adhérents</title>
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
        <h1>Liste des Clubs et Adhérents</h1>
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nom du Club</th>
                        <th>Noms des Adhérents</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($clubs as $club): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($club['ClubLibelle']); ?></td>
                            <td><?php echo htmlspecialchars($club['Adherents']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
