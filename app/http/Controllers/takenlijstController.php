<?php 


session_start(); 
require_once '../../../backend/conn.php'; // Databaseverbinding

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $username = $_POST['user'];
    $password = $_POST['pass'];

    // Query om de gebruiker te vinden 
    $query = "SELECT * FROM gebruikers WHERE gebruikersnaam = :username AND wachtwoord = :password";
    $stmt = $conn->prepare($query);
    $stmt->execute([
        ':username' => $username,
        ':password' => $password 
    ]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Inloggen succesvol
        $_SESSION['user'] = $username; // Sla de gebruikersnaam op in de sessie
        header('Location: ../../tasks/index.php'); // Doorsturen naar takenlijst
        exit;
    } else {
        // Inloggen mislukt
        echo "Ongeldige gebruikersnaam of wachtwoord.";
    }
}
?>
    
?>