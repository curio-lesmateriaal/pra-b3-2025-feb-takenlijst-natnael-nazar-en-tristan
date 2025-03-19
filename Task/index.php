<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: ../login.php');
    exit;
}

require_once '../backend/conn.php';

// Query om actieve taken op te halen
$query = "SELECT id, titel, afdeling, status, created_at, deadline FROM taken WHERE status <> 'done'";
$stmt = $conn->prepare($query);
$stmt->execute();
$taken = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Status updaten als er een formulier is ingediend
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $taakId = $_POST['taak_id'];
    $nieuweStatus = $_POST['status'];

    $updateQuery = "UPDATE taken SET status = :status WHERE id = :id";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->execute(['status' => $nieuweStatus, 'id' => $taakId]);

    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Takenlijst</title>
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="taakbord.css">
</head>
<body>
    <header>
        <h1>Takenlijst</h1>
        <nav>
            <a href="create.php">Nieuwe taak toevoegen</a>
            <a href="done.php">Voltooide taken bekijken</a>
            <a href="../app/http/Controllers/logoutController.php">Uitloggen</a>
        </nav>
    </header>

    <main>
        <h2>Welkom, <?php echo htmlspecialchars($_SESSION['user']); ?>!</h2>
        <h3>Actieve taken</h3>
        <div class="task-box">
            <?php if (count($taken) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Titel</th>
                            <th>Afdeling</th>
                            <th>Aangemaakt op</th>
                            <th>Deadline</th>
                            <th>Status</th>
                            <th>Actie</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($taken as $taak): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($taak['titel']); ?></td>
                                <td><?php echo htmlspecialchars($taak['afdeling']); ?></td>
                                <td><?php echo htmlspecialchars($taak['created_at'] ?? 'Geen datum beschikbaar'); ?></td>
                                <td><?php echo htmlspecialchars($taak['deadline'] ?? 'Geen deadline'); ?></td>
                                <td>
                                    <form class="status-form" method="POST" action="index.php">
                                        <input type="hidden" name="taak_id" value="<?php echo $taak['id']; ?>">
                                        <select name="status" onchange="this.form.submit()">
                                            <option value="todo" <?php echo $taak['status'] === 'todo' ? 'selected' : ''; ?>>To-do</option>
                                            <option value="in_progress" <?php echo $taak['status'] === 'in_progress' ? 'selected' : ''; ?>>In Progress</option>
                                            <option value="done" <?php echo $taak['status'] === 'done' ? 'selected' : ''; ?>>Finished</option>
                                        </select>
                                        <input type="hidden" name="update_status" value="1">
                                    </form>
                                </td>
                                <td>
                                    <form method="POST" action="../../../app/http/Controllers/DeleteTaskController.php" style="display: inline;">
                                        <input type="hidden" name="taak_id" value="<?php echo $taak['id']; ?>">
                                        <button type="submit" name="delete_task" class="delete-btn">Verwijderen</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Er zijn geen actieve taken.</p>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>