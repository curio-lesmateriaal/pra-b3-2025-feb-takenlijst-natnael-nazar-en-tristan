<?php
session_start();

// Controleer gebruiker authenticatie
if (!isset($_SESSION['user'])) {
    header('Location: ../login.php');
    exit;
}

//1. Verbinding
require_once __DIR__ . '/../backend/conn.php';

//2. Query
$query = "SELECT id, titel, beschrijving, afdeling, status, created_at, deadline FROM taken WHERE status = 'done'";

//3. Prepare
$statement = $conn->prepare($query);

//4. Execute
$statement->execute();

//5. Fetch
$voltooide_taken = $statement->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_task'])) {
    $taakId = $_POST['taak_id'];

    //2. Query
    $deleteQuery = "DELETE FROM taken WHERE id = :id";
    
    //3. Prepare
    $deleteStmt = $conn->prepare($deleteQuery);
    
    //4. Execute
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
                <p>Beschrijving: <?php echo $taak['beschrijving']; ?></p>
                <p>Aangemaakt op: <?php echo $taak['created_at']; ?></p>
                <p>Deadline: <?php echo $taak['deadline']; ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>