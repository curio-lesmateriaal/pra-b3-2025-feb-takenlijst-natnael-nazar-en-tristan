<?php
session_start();

// Stap 1: Pak de databaseverbinding erbij
require_once __DIR__ . '/../../../backend/conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['user'];
    $password = $_POST['pass'];

    // Stap 2: Schrijf de query met placeholders
    $query = "SELECT * FROM users WHERE username = :username";

    // Stap 3: Zet om naar prepared statement
    $statement = $conn->prepare($query);

    // Stap 4: Voer het statement uit
    $statement->execute([':username' => $username]);

    // Stap 5: Haal het resultaat op
    $user = $statement->fetch();

    if ($user && $password === $user['password']) {
        $_SESSION['user'] = $username;
        header('Location: /Task/index.php');
        exit;
    } else {
        echo "Ongeldige gebruikersnaam of wachtwoord.";
    }
}
?>
