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
$query = "SELECT id, titel, afdeling, status FROM taken WHERE status <> 'done' ORDER BY deadline ASC";

// Stap 3: Zet om naar prepared statement
$statement = $conn->prepare($query);

// Stap 4: Voer het statement uit
$statement->execute();

// Stap 5: Haal het resultaat op
$taken = $statement->fetchAll();

// Organiseer taken per status
$takenPerStatus = [
    'todo' => [],
    'in_progress' => []
];

foreach ($taken as $taak) {
    $takenPerStatus[$taak['status']][] = $taak;
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Takenbord</title>
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="taakbord.css">
</head>
<body>
    <header>
        <h1>Takenbord</h1>
        <div>
            <a href="create.php" class="button">Nieuwe taak</a>
            <a href="done.php" class="button">Voltooide taken</a>
            <a href="../app/http/Controllers/logoutController.php" class="button">Uitloggen</a>
        </div>
    </header>
    <div class="kanban-board">
        <div class="kanban-column">
            <h2>Te Doen</h2>
            <?php foreach ($takenPerStatus['todo'] as $taak): ?>
                <div class="task-card">
                    <h3><?php echo $taak['titel']; ?></h3>
                    <p>Afdeling: <?php echo $taak['afdeling']; ?></p>
                    <a href="edit.php?id=<?php echo $taak['id']; ?>" class="button">Bewerk</a>
                    <form method="POST" action="../app/http/Controllers/TaskController.php" style="display: inline;">
                        <input type="hidden" name="taak_id" value="<?php echo $taak['id']; ?>">
                        <input type="hidden" name="action" value="delete">
                        <button type="submit" class="delete-button">Verwijder</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="kanban-column">
            <h2>In Uitvoering</h2>
            <?php foreach ($takenPerStatus['in_progress'] as $taak): ?>
                <div class="task-card">
                    <h3><?php echo $taak['titel']; ?></h3>
                    <p>Afdeling: <?php echo $taak['afdeling']; ?></p>
                    <a href="edit.php?id=<?php echo $taak['id']; ?>" class="button">Bewerk</a>
                    <form method="POST" action="../app/http/Controllers/TaskController.php" style="display: inline;">
                        <input type="hidden" name="taak_id" value="<?php echo $taak['id']; ?>">
                        <input type="hidden" name="action" value="delete">
                        <button type="submit" class="delete-button">Verwijder</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>