<?php
session_start(); 
require_once __DIR__ . '/../../../backend/conn.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['user'];
    $password = $_POST['pass'];

    $query = "SELECT * FROM `users` WHERE username = :username";
    $stmt = $conn->prepare($query);
    $stmt->execute([':username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && $password === $user['password']) {
 
        $_SESSION['user'] = $username; 
        header('Location: /task/index.php');

        exit;
    } else {
        // Inloggen mislukt
        echo "Ongeldige gebruikersnaam of wachtwoord.";
    }
}
?>
