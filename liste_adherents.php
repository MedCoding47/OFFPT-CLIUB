<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Liste des Adhérents</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Liste des Adhérents</h1>
        <table id="example" class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                    <th>Filière</th>
                    <th>Valide</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include_once("connexion.php");
                $query = "SELECT CodeAdhrents, Nom, email, telephone, fielere, valide FROM Adherents";
                $pdostmt = $connexion->prepare($query);
                $pdostmt->execute();
                while ($ligne = $pdostmt->fetch(PDO::FETCH_ASSOC)):
                ?>
                <tr>
                    <td><?php echo $ligne["CodeAdhrents"]; ?></td>
                    <td><?php echo $ligne["Nom"]; ?></td>
                    <td><?php echo $ligne["email"]; ?></td>
                    <td><?php echo $ligne["telephone"]; ?></td>
                    <td><?php echo $ligne["fielere"]; ?></td>
                    <td><?php echo $ligne["valide"] ? 'Oui' : 'Non'; ?></td>
                    <td>
                        <?php if (!$ligne["valide"]): ?>
                        <form action="valider_adherent.php" method="POST">
                            <input type="hidden" name="code_adherent" value="<?php echo $ligne["CodeAdhrents"]; ?>">
                            <button type="submit" class="btn btn-success">Valider</button>
                        </form>
                        <?php endif; ?>
                        <a href="supprimer_adherent.php?id=<?php echo $ligne["CodeAdhrents"]; ?>"
                            class="btn btn-danger" onclick="return confirm('Etes-vous sûr de supprimer cet événement ?')">Supprimer</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
