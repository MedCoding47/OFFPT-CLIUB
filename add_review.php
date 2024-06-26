<?php
session_start();
include_once("connexion.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_review'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $review = $_POST['review'];
    $event_code = $_POST['event_code'];

    // Validate email and password
    $sql_validate = "SELECT * FROM Adherents WHERE email = :email AND pwd = :pwd";
    $stmt_validate = $connexion->prepare($sql_validate);
    $stmt_validate->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt_validate->bindParam(':pwd', $password, PDO::PARAM_STR);
    $stmt_validate->execute();

    if ($stmt_validate->rowCount() > 0) {
        $user = $stmt_validate->fetch(PDO::FETCH_ASSOC);
        $user_id = $user['CodeAdhrents'];

        // Insert the review into the database
        $sql_insert_review = "INSERT INTO Reviews (CodeAdhrents, event_code, review) VALUES (:user_id, :event_code, :review)";
        $stmt_insert_review = $connexion->prepare($sql_insert_review);
        $stmt_insert_review->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt_insert_review->bindParam(':event_code', $event_code, PDO::PARAM_INT);
        $stmt_insert_review->bindParam(':review', $review, PDO::PARAM_STR);
        $stmt_insert_review->execute();

        // Redirect to event details page with success message
        header("Location: acceuil.php");
        
        exit();
    } else {
        $_SESSION['error_message'] = "Email or password incorrect.";
    }
}

$event_code = isset($_GET['event_code']) ? intval($_GET['event_code']) : 0;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Add Review</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        form {
            margin-top: 20px;
        }
        label {
            font-weight: bold;
        }
        input[type="email"],
        input[type="password"],
        textarea,
        button {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            box-sizing: border-box;
        }
        button {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Add Your Review</h2>
        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="alert alert-danger">
                <?php echo htmlspecialchars($_SESSION['error_message']); ?>
            </div>
            <?php unset($_SESSION['error_message']); ?>
        <?php endif; ?>
        <form method="post">
            <input type="hidden" name="event_code" value="<?php echo $event_code; ?>">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="review" class="form-label">Your Review</label>
                <textarea class="form-control" id="review" name="review" rows="5" required></textarea>
            </div>
            <button type="submit" name="submit_review" class="btn btn-primary">Submit Review</button>
        </form>
    </div>
</body>
</html>
