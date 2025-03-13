<?php
session_start(); // Start de sessie
require_once __DIR__ . '/../../../backend/conn.php'; // Databaseverbinding

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['user'];
    $password = $_POST['pass'];

    // Gebruik de juiste tabel- en kolomnamen
    $query = "SELECT * FROM `users` WHERE username = :username";
    $stmt = $conn->prepare($query);
    $stmt->execute([':username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vergelijk de wachtwoorden direct zonder password_verify()
    if ($user && $password === $user['password']) {
        // Inloggen succesvol
        $_SESSION['user'] = $username; // Sla de gebruikersnaam op in de sessie
        header('Location: /task/index.php');
 // Doorsturen naar takenlijst
        exit;
    } else {
        // Inloggen mislukt
        echo "Ongeldige gebruikersnaam of wachtwoord.";
    }
}
?>
