<?php
session_start();

// Controleer gebruiker authenticatie
if (!isset($_SESSION['user'])) {
    header('Location: ../login.php');
    exit;
}

//1. Verbinding
require_once __DIR__ . '/../backend/conn.php';

// Haal user ID op
$userQuery = "SELECT id FROM users WHERE username = :username";
$userStmt = $conn->prepare($userQuery);
$userStmt->execute(['username' => $_SESSION['user']]);
$user = $userStmt->fetch();
$userId = $user['id'];

//2. Query
$query = "SELECT id, titel, beschrijving, afdeling, status, deadline FROM taken WHERE user = :user ORDER BY deadline ASC";

//3. Prepare
$statement = $conn->prepare($query);

//4. Execute
$statement->execute([
    'user' => $userId
]);

//5. Fetch
$taken = $statement->fetchAll();

// Organiseer taken per status
$takenPerStatus = [
    'todo' => [],
    'in_progress' => [],
    'done' => []
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
    <title>Mijn Taken</title>
    <link rel="stylesheet" href="../css/main.css">
</head>
<body>
    <header>
        <h1 class="tekst-white">Mijn Taken</h1>
        <div>
            <a href="index.php" class="button">Alle taken</a>
            <a href="create.php" class="button">Nieuwe taak</a>
            <a href="../app/http/Controllers/logoutController.php" class="button">Uitloggen</a>
        </>
    </header>
    <div class="kanban-board">
        <div class="kanban-column">
            <h2>Te Doen</h2>
            <?php foreach ($takenPerStatus['todo'] as $taak): ?>
                <div class="task-card">
                    <h3><?php echo $taak['titel']; ?></h3>
                    <p>Afdeling: <?php echo $taak['afdeling']; ?></p>
                    <p>Beschrijving: <?php echo $taak['beschrijving']; ?></p>
                    <p>Deadline: <?php echo date('d-m-Y', strtotime($taak['deadline'])); ?></p>
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
                    <p>Beschrijving: <?php echo $taak['beschrijving']; ?></p>
                    <p>Deadline: <?php echo date('d-m-Y', strtotime($taak['deadline'])); ?></p>
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
            <h2>Voltooid</h2>
            <?php foreach ($takenPerStatus['done'] as $taak): ?>
                <div class="task-card">
                    <h3><?php echo $taak['titel']; ?></h3>
                    <p>Afdeling: <?php echo $taak['afdeling']; ?></p>
                    <p>Beschrijving: <?php echo $taak['beschrijving']; ?></p>
                    <p>Deadline: <?php echo date('d-m-Y', strtotime($taak['deadline'])); ?></p>
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