<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Evenements</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Liste des Evenements</h1>
        <a href="process_event.php" class="btn btn-primary mb-3">Ajouter un Evenement</a>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Code Club</th>
                    <th>Event Name</th>
                    <th>jourP</th>
                    <th>DateR</th>
                    <th>Description</th>
                    <th>Observation</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php
            include_once("connexion.php");
            $query = "SELECT e.code, c.libelle AS ClubName, e.nom_event, e.jourP, e.DateR, e.Description, e.Observation, e.picture_path
                      FROM Evenements e
                      INNER JOIN Club c ON e.CodeClub = c.CodeClub";
            $pdostmt = $connexion->prepare($query);
            $pdostmt->execute();
            while ($ligne = $pdostmt->fetch(PDO::FETCH_ASSOC)):
            ?>
            <tr>
                <td><?php echo $ligne["code"]; ?></td>
                <td><?php echo $ligne["ClubName"]; ?></td>
                <td><?php echo $ligne["nom_event"]; ?></td>
                <td><?php echo $ligne["jourP"]; ?></td>
                <td><?php echo $ligne["DateR"]; ?></td>
                <td><?php echo $ligne["Description"]; ?></td>
                <td><?php echo $ligne["Observation"]; ?></td>
                <td>
                    <?php if (!empty($ligne["picture_path"])): ?>
                        <img src="<?php echo $ligne["picture_path"]; ?>" alt="Event Picture" style="max-width: 200px; max-height: 200px;">
                    <?php else: ?>
                        No Picture Available
                    <?php endif; ?>
                </td>
                <td>
                    <a href="Modifevents.php?id=<?php echo $ligne["code"] ?>" class="btn btn-success">Edit</a>
                    <a href="eventssuppression.php?id=<?php echo $ligne["code"]; ?>" class="btn btn-danger" onclick="return confirm('Etes-vous sûr de supprimer cet événement ?')">Supprimer</a>
                </td>
            </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
