<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Responsable Inscription Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <style>
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Responsable Inscription Form</h2>
        <form method="post">
            <div class="mb-3">
                <label for="Nom" class="form-label">Nom:</label>
                <input type="text" id="Nom" name="Nom" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="Email" class="form-label">Email:</label>
                <input type="email" id="Email" name="Email" class="form-control">
            </div>
            <div class="mb-3">
                <label for="Address" class="form-label">Address:</label>
                <input type="text" id="Address" name="Address" class="form-control">
            </div>
            <div class="mb-3">
                <label for="Role" class="form-label">Role:</label>
                <input type="text" id="Role" name="Role" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="DateOfBirth" class="form-label">Date of Birth:</label>
                <input type="date" id="DateOfBirth" name="DateOfBirth" class="form-control">
            </div>
            <div class="mb-3">
                <label for="Gender" class="form-label">Gender:</label>
                <input type="text" id="Gender" name="Gender" class="form-control">
            </div>
            <div class="mb-3">
                <label for="Phone" class="form-label">Phone:</label>
                <input type="tel" id="Phone" name="Phone" class="form-control">
            </div>
            <div class="mb-3">
                <label for="pwd" class="form-label">Password:</label>
                <input type="password" id="pwd" name="pwd" class="form-control">
            </div>
            <input type="submit" value="Submit" class="btn btn-info">
        </form>
    </div>
    <?php
    // PHP code to handle form submission
    include_once("connexion.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (!empty($_POST["Nom"]) && !empty($_POST["Role"])) {
            try {
                $query = "INSERT INTO Responsable (Nom, Email, Address, Role, DateOfBirth, Gender, Phone, pwd) 
                          VALUES (:Nom, :Email, :Address, :Role, :DateOfBirth, :Gender, :Phone, :pwd)";
                $pdostmt = $connexion->prepare($query);
                $pdostmt->execute([
                    "Nom" => $_POST["Nom"],
                    "Email" => $_POST["Email"],
                    "Address" => $_POST["Address"],
                    "Role" => $_POST["Role"],
                    "DateOfBirth" => $_POST["DateOfBirth"],
                    "Gender" => $_POST["Gender"],
                    "Phone" => $_POST["Phone"],
                    "pwd" => $_POST["pwd"]
                ]);
                $pdostmt->closeCursor();
                header("Location: ListeResponsables.php");
                exit();
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }
        } else {
            echo "<p class='text-danger'>Nom and Role fields are required.</p>";
        }
    }
    ?>
</body>
</html>
