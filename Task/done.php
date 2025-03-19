<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: ../login.php');
    exit;
}

require_once '../backend/conn.php';

// Voltooide taken ophalen
$query = "SELECT id, titel, beschrijving, afdeling, status, created_at FROM taken WHERE status = 'done'";
$stmt = $conn->prepare($query);
$stmt->execute();
$taken = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Taak verwijderen als er een verwijderverzoek is
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_task'])) {
    $taakId = $_POST['taak_id'];

    $deleteQuery = "DELETE FROM taken WHERE id = :id";
    $deleteStmt = $conn->prepare($deleteQuery);
    $deleteStmt->execute(['id' => $taakId]);

    // Vernieuw de pagina om de wijzigingen te tonen
    header('Location: done.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voltooide Taken</title>
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="taakbord.css">
    </style>
</head>
<body>
    <header>
        <h1>Voltooide Taken</h1>
        <nav>
            <a href="index.php">Terug naar takenlijst</a>
            <a href="../app/http/Controllers/logoutController.php">Uitloggen</a>
        </nav>
    </header>

    <main>
        <div class="task-box">
            <h2>Voltooide Taken</h2>
            <?php if (count($taken) > 0): ?>
                <?php foreach ($taken as $taak): ?>
                    <div class="taak">
                        <h3><?= htmlspecialchars($taak['titel']) ?></h3>
                        <p><strong>Afdeling:</strong> <?= htmlspecialchars($taak['afdeling']) ?></p>
                        <p><strong>Status:</strong> <?= htmlspecialchars($taak['status']) ?></p>
                        <p><strong>Aangemaakt op:</strong> <?= htmlspecialchars($taak['created_at']) ?></p>
                        <p><?= nl2br(htmlspecialchars($taak['beschrijving'])) ?></p>
                        <form method="POST" action="done.php" style="display: inline;">
                            <input type="hidden" name="taak_id" value="<?= $taak['id'] ?>">
                            <button type="submit" name="delete_task" class="delete-btn">Verwijderen</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Er zijn geen voltooide taken.</p>
            <?php endif; ?>
        </div>
    </main>

    <footer>
        &copy; 2025 Developer Land Takenbord.
    </footer>
</body>
</html>