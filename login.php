<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de login</title>
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">

<!-- Main css -->
<link rel="stylesheet" href="style.css">
   
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
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
<body>
<div class="main">

<!-- Sing in  Form -->
<section class="sign-in">
    <div class="container">
        <div class="signin-content">
            <div class="signin-image">
                <figure><img src="pics/55.jpg" alt="sing up image"></figure>
                
            </div>

            <div class="signin-form">
                <h2 class="form-title">Sign up</h2>
            <?php
            session_start();
            include_once("connexion.php");

            $error_message = ""; // Initialize an empty error message

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (!empty($_POST["Email"]) && !empty($_POST["pwd"])) {
                    $query = "SELECT * FROM Responsable WHERE Email = :Email AND pwd = :pwd";
                    $pdostmt = $connexion->prepare($query);
                    $pdostmt->execute(["Email" => $_POST["Email"], "pwd" => $_POST["pwd"]]);

                    $responsable = $pdostmt->fetch();
                    $pdostmt->closeCursor();

                    if ($responsable) {
                        // Save user information in the session
                        $_SESSION['CodeEleve'] = $responsable['Code'];
                        $_SESSION['Nom'] = $responsable['Nom'];

                        // Redirect to the welcome page
                        header("Location: welcome.php");
                        exit();
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
            ?>
            <form method="POST" class="register-form" id="login-form">
                            <div class="form-group">
                                <label for="your_name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" class="form-control" id="Email" placeholder="Enter Email" name="Email">                            
                            </div>
                            <div class="form-group">
                                <label for="your_pass"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" class="form-control" id="pwd" placeholder="Enter Password" name="pwd">
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
</body>
</html>
