<?php
include_once("connexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $telephone = $_POST['telephone'];
    $pwd = $_POST['pwd'];
    $email = $_POST['email'];
    $filiere = $_POST['filiere'];
    $valide = false;
    $codeClub = $_POST['codeClub'];

    try {
        $sql = "INSERT INTO Adherents (CodeClub, Nom, prenom, telephone, pwd, email, filiere, valide) 
                VALUES (:codeClub, :nom, :prenom, :telephone, :pwd, :email, :filiere, :valide)";
        
        $stmt = $connexion->prepare($sql);
        
        $stmt->bindParam(':codeClub', $codeClub, PDO::PARAM_INT);
        $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
        $stmt->bindParam(':prenom', $prenom, PDO::PARAM_STR);
        $stmt->bindParam(':telephone', $telephone, PDO::PARAM_STR);
        $stmt->bindParam(':pwd', $pwd, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':valide', $valide, PDO::PARAM_BOOL); // Use PDO::PARAM_BOOL for boolean
        $stmt->bindParam(':filiere', $filiere, PDO::PARAM_STR);

        if ($stmt->execute()) {
            header("Location: loginadherent.php");
            exit();
        } else {
            echo "Erreur lors de l'enregistrement de l'adhérent.";
        }
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
} else {
    echo "Les données du formulaire ne sont pas présentes.";
}
?>
