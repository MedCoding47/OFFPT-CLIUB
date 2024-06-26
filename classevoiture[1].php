<?php

class Voiture {
    private $matricule;
    public $marque;
    public $annee;
    private $numClient;
    

    public function __construct($matricule, $marque, $annee, $numClient) {
        $this->matricule = $matricule;
        $this->marque = $marque;
        $this->annee = $annee;
        $this->numClient = $numClient;
    }
    
   // Getter pour matricule
   public function getMatricule() {
    return $this->matricule;
}

// Getter pour numClient
public function getNumClient() {
    return $this->numClient;
}

// Setter pour numClient
public function setNumClient($numClient) {
    $this->numClient = $numClient;
}
    // Setter pour numClient
public function setmatricule($matricule) {
    $this->matricule = $matricule;
}
    public function __toString() {
        return "Matricule: " . $this->matricule . "\tMarque: " . $this->marque . "\tAnnée: " . $this->annee . "\tNuméro Client: " . $this->numClient;
    }


}



<?php
include 'db_connect.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['connexion'])) {
    $num_client = $_POST['num_client'];
    $matricule = $_POST['matricule'];

    $sql = "SELECT * FROM Voiture WHERE NumClient='$num_client' AND Matricule='$matricule'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $_SESSION['num_client'] = $num_client;
        $_SESSION['matricule'] = $matricule;
        header("Location: Reparation.php");
        exit();
    } else {
        echo "Identifiants incorrects";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Connexion</title>
</head>
<body>
    <h2>Connexion</h2>
    <form method="post" action="Connection.php">
        NumClient: <input type="text" name="num_client" required>
        Matricule: <input type="text" name="matricule" required>
        <button type="submit" name="connexion">Se connecter</button>
    </form>
</body>
</html>

<?php
$conn->close();
?>



<?php
include 'db_connect.php';

session_start();

if (!isset($_SESSION['num_client']) || !isset($_SESSION['matricule'])) {
    header("Location: Connection.php");
    exit();
}

$num_client = $_SESSION['num_client'];
$matricule = $_SESSION['matricule'];

// Récupération des informations de la voiture
$sql = "SELECT * FROM Voiture WHERE Matricule='$matricule'";
$voiture_result = $conn->query($sql);
$voiture = $voiture_result->fetch_assoc();

// Récupération des réparations
$sql = "SELECT * FROM Reparation WHERE Matricule='$matricule'";
$reparations = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Historique des Réparations</title>
</head>
<body>
    <h2>Informations de la Voiture avec  <span style="color: red;">Matricule &nbsp;<?php echo $matricule; ?></span> </h2>
    <p>Marque: <?php echo $voiture['Marque']; ?></p>
    <p>Année: <?php echo $voiture['Annee']; ?></p>
    <p>NumClient: <?php echo $voiture['NumClient']; ?></p>

    <h2>Historique des Réparations</h2>
    <table border="1">
        <tr>
            <th>NumRep</th>
            <th>Description</th>
            <th>DateRep</th>
            <th>Coût</th>
        </tr>
        <?php
        if ($reparations->num_rows > 0) {
            while($row = $reparations->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["NumRep"] . "</td>";
                echo "<td>" . $row["Description"] . "</td>";
                echo "<td>" . $row["DateRep"] . "</td>";
                echo "<td>" . $row["coût"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>Aucune réparation trouvée</td></tr>";
        }
        ?>
    </table>
</body>
</html>

<?php
$conn->close();
?>


<?php
include 'db_connect.php';

// Récupération des informations de la voiture
if (isset($_GET['matricule'])) {
    $matricule = $_GET['matricule'];
    $sql = "SELECT * FROM Voiture WHERE Matricule='$matricule'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $voiture = $result->fetch_assoc();
    } else {
        echo "Voiture non trouvée";
        exit();
    }
}

// Modification de la voiture
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['modifier'])) {
    $marque = $_POST['marque'];
    $annee = $_POST['annee'];
    $num_client = $_POST['num_client'];

    $sql = "UPDATE Voiture SET Marque='$marque', Annee='$annee', NumClient='$num_client' WHERE Matricule='$matricule'";
    if ($conn->query($sql) === TRUE) {
        header("Location: ListeVoiture.php?message=success");
        exit();
    } else {
        echo "Erreur: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Modifier Voiture</title>
</head>
<body>
    <h2>Modifier Voiture</h2>
    <form method="post" action="ModifierVoiture.php?matricule=<?php echo $matricule; ?>">
        Marque: <input type="text" name="marque" value="<?php echo $voiture['Marque']; ?>" required>
        Année: <input type="text" name="annee" value="<?php echo $voiture['Annee']; ?>" required>
        NumClient: <input type="text" name="num_client" value="<?php echo $voiture['NumClient']; ?>" required>
        <button type="submit" name="modifier">Modifier</button>
    </form>
</body>
</html>

<?php
$conn->close();
?>