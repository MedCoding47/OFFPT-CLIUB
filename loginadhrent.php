<!DOCTYPE html>
<html>
<head>
    <title>Page de login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <style>
        form {
            width: 400px;
        }
        h1 {
            text-align: center;
            margin-top: 50px;
        }
        h1 span {
            color: aqua;
        }
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .alert {
            width: 100%;
            margin-bottom: 20px;
        }
    </style>
</head>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign Up Form by Colorlib</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="main">

        <!-- Sing in  Form -->
        <section class="sign-in">
            <div class="container">
                <div class="signin-content">
                    <div class="signin-image">
                    <figure><img src="pics/55.jpg" alt="sing up image"></figure>

                        <a  href="ajout_adherent.php" class="signup-image-link">Create an account</a>
                          <a href="forgot_password.php" class="signup-image-link">Mot de passe oublié ?</a>
                    </div>

                    <div class="signin-form">
                        <h2 class="form-title">Sign up</h2>
                        <?php
                        session_start();
                        include_once("connexion.php");
            
                        $error_message = "";
            
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            if (!empty($_POST["email"]) && !empty($_POST["pwd"])) {
                                $query = "SELECT * FROM Adherents WHERE email = :email AND pwd = :pwd";
                                $pdostmt = $connexion->prepare($query);
                                $pdostmt->execute(["email" => $_POST["email"], "pwd" => $_POST["pwd"]]);
            
                                $Adherents = $pdostmt->fetch();
                                $pdostmt->closeCursor();
            
                                if ($Adherents) {
                                    if ($Adherents['valide']) {
                                        // Save user information in the session
                                        $_SESSION['CodeAdhrents'] = $Adherents['CodeAdhrents'];
                                        $_SESSION['Nom'] = $Adherents['Nom'];
            
                                        // Redirect to the profile page
                                        header("Location: profiladhrent.php");
                                        exit();
                                    } else {
                                        // User is not validated
                                        $error_message = "Votre compte n'est pas encore validé. Veuillez contacter l'administrateur.";
                                    }
                                } else {
                                    // Incorrect identifier or password
                                    $error_message = "Identifiant ou mot de passe incorrect.";
                                }
                            } else {
                                $error_message = "Veuillez remplir tous les champs.";
                            }
                        }
            
                        if (!empty($error_message)) {
                            echo '<div class="alert alert-danger">' . $error_message . '</div>';
                        }
            
                        // Display success message if the account was deleted
                        if (isset($_GET['account_deleted']) && $_GET['account_deleted'] == 'true') {
                            echo '<div class="alert alert-success">Compte supprimé avec succès. Veuillez vous connecter avec vos informations.</div>';
                        }
            
                        // Display success message if the password was changed
                        if (isset($_GET['password_changed']) && $_GET['password_changed'] == 'true') {
                            echo '<div class="alert alert-success">Mot de passe changé avec succès. Veuillez vous connecter avec votre nouveau mot de passe.</div>';
                        }
                        ?>
                        <form method="POST" class="register-form" id="login-form">
                            <div class="form-group">
                                <label for="your_name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" class="form-control" id="email" placeholder="Entrez email" name="email"/>
                            </div>
                            <div class="form-group">
                                <label for="your_pass"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" class="form-control" id="pwd" placeholder="Entrez le mot de passe" name="pwd"/>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" name="remember-me" id="remember-me" class="agree-term" />
                                <label for="remember-me" class="label-agree-term"><span><span></span></span>Remember me</label>
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="signin" id="signin" class="form-submit" value="Log in"/>
                            </div>
                        </form>
                        
                    </div>
                </div>
            </div>
        </section>

    </div>

    <!-- JS -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="js/main.js"></script>
</body><!-- This templates was made by Colorlib (https://colorlib.com) -->
</html>        
</html>
