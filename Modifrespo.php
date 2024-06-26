<?php
include_once("connexion.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the details of the responsable with the given id
    $query = "SELECT Code, Nom, Email, Address, Role, DateOfBirth, Gender, Phone, pwd FROM Responsable WHERE Code = :id";
    $pdostmt = $connexion->prepare($query);
    $pdostmt->execute(['id' => $id]);
    $responsable = $pdostmt->fetch(PDO::FETCH_ASSOC);

    if (!$responsable) {
        echo "Responsable not found.";
        exit;
    }
} else {
    echo "No responsable id provided.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Update the responsable record with the new data
    $query = "UPDATE Responsable SET 
                Nom = :Nom, 
                Email = :Email, 
                Address = :Address, 
                Role = :Role, 
                DateOfBirth = :DateOfBirth, 
                Gender = :Gender, 
                Phone = :Phone, 
                pwd = :pwd 
              WHERE Code = :id";

    $pdostmt = $connexion->prepare($query);
    $pdostmt->execute([
        'Nom' => $_POST['Nom'],
        'Email' => $_POST['Email'],
        'Address' => $_POST['Address'],
        'Role' => $_POST['Role'],
        'DateOfBirth' => $_POST['DateOfBirth'],
        'Gender' => $_POST['Gender'],
        'Phone' => $_POST['Phone'],
        'pwd' => $_POST['pwd'],
        'id' => $id
    ]);

    header("Location: ListeResponsables.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Responsable</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <h1 class="mt-5">Modifier Responsable</h1>
        <form method="POST">
            <div class="mb-3">
                <label for="Nom" class="form-label">Nom</label>
                <input type="text" class="form-control" id="Nom" name="Nom" value="<?php echo $responsable['Nom']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="Email" class="form-label">Email</label>
                <input type="email" class="form-control" id="Email" name="Email" value="<?php echo $responsable['Email']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="Address" class="form-label">Address</label>
                <input type="text" class="form-control" id="Address" name="Address" value="<?php echo $responsable['Address']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="Role" class="form-label">Role</label>
                <input type="text" class="form-control" id="Role" name="Role" value="<?php echo $responsable['Role']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="DateOfBirth" class="form-label">Date of Birth</label>
                <input type="date" class="form-control" id="DateOfBirth" name="DateOfBirth" value="<?php echo $responsable['DateOfBirth']; ?>" required>
            </div>
            <div class="mb-3">
    <label for="Gender" class="form-label">Gender:</label>
    <input type="text" id="Gender" name="Gender" class="form-control" value="<?php echo ($responsable['Gender']); ?>" required>
</div>

            <div class="mb-3">
                <label for="Phone" class="form-label">Phone</label>
                <input type="text" class="form-control" id="Phone" name="Phone" value="<?php echo $responsable['Phone']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="pwd" class="form-label">Password</label>
                <input type="password" class="form-control" id="pwd" name="pwd" value="<?php echo $responsable['pwd']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
    </div>
</body>

</html>
