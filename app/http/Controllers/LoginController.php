<?php
session_start();

//1. Verbinding
require_once __DIR__ . '/../../../backend/conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //Variabelen vullen
    $username = $_POST['user'];
    $password = $_POST['pass'];

    //2. Query
    $query = "SELECT * FROM users WHERE username = :username";

    //3. Prepare
    $statement = $conn->prepare($query);

    //4. Execute
    $statement->execute([':username' => $username]);

    //5. Fetch
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
