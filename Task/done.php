<?php
session_start();

// Controleer gebruiker authenticatie
if (!isset($_SESSION['user'])) {
    header('Location: ../login.php');
    exit;
}

// Stap 1: Pak de databaseverbinding erbij
require_once __DIR__ . '/../backend/conn.php';

// Stap 2: Schrijf de query met placeholders
$query = "SELECT titel, afdeling FROM taken WHERE status = 'done'";

// Stap 3: Zet om naar prepared statement
$statement = $conn->prepare($query);

// Stap 4: Voer het statement uit
$statement->execute();

// Stap 5: Haal het resultaat op
$voltooide_taken = $statement->fetchAll();


$query = "SELECT id, titel, beschrijving, afdeling, status, created_at, deadline FROM taken WHERE status = 'done'";
$stmt = $conn->prepare($query);
$stmt->execute();
$taken = $stmt->fetchAll(PDO::FETCH_ASSOC);


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_task'])) {
    $taakId = $_POST['taak_id'];

    $deleteQuery = "DELETE FROM taken WHERE id = :id";
    $deleteStmt = $conn->prepare($deleteQuery);
    $deleteStmt->execute(['id' => $taakId]);

    header('Location: done.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Voltooide Taken</title>
    <link rel="stylesheet" href="../css/main.css">
</head>
<body>
    <header>
        <h1>Voltooide Taken</h1>
        <a href="index.php" class="button">Terug</a>
    </header>

    <div class="task-list">
        <?php foreach ($voltooide_taken as $taak): ?>
            <div class="task-card">
                <h3><?php echo $taak['titel']; ?></h3>
                <p>Afdeling: <?php echo $taak['afdeling']; ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>