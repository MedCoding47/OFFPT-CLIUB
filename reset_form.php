<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <title>Réinitialiser le mot de passe</title>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 400px;
            margin-top: 100px;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            margin-bottom: 20px;
            color: #007bff;
            text-align: center;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        .form-label {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Réinitialiser le mot de passe</h1>
        <form method="post" action="update_password.php">
            <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">
            <div class="mb-3 mt-3">
                <label for="new_password" class="form-label">Nouveau mot de passe :</label>
                <input type="password" class="form-control" id="new_password" name="new_password" required>
            </div>
            <div class="mb-3 mt-3">
                <label for="confirm_password" class="form-label">Confirmez le mot de passe :</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
            </div>
            <button type="submit" class="btn btn-primary">Réinitialiser</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3BF0XUYXK4A/vyyaX/ZdA6+Wj/qnY1dFVmsMSzQJpfIdYyIIjycW9ApyH3iKnQJ" crossorigin="anonymous"></script>
</body>
</html>
