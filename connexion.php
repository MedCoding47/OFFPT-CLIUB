<?php
$host = 'localhost'; 
$dbname = 'gest_club'; 
$username = 'root';
$password = 'root'; 

try {
    $connexion = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

} catch (PDOException $e) 
{
    die("Impossible de se connecter à la base de donnée $dbname :" . $e->getMessage());
}
?>




