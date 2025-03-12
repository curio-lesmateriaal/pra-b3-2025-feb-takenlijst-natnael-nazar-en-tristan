<?php require_once 'create.php'; ?>

<?php
require_once '../backend/conn.php';

$query = "SELECT titel, afdeling, status FROM taken WHERE status <> 'done'";
$stmt = $conn->prepare($query);
$stmt->execute();
$taken = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Takenlijst</title>
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/main.css">
</head>
<body>
    <header>
        <h1>Takenlijst</h1>
        <nav>
            <a href="create.php">Nieuwe taak toevoegen</a>
            <a href="done.php">Voltooide taken bekijken</a>
        </nav>
    </header>

    <main>
        <h2>Actieve taken</h2>
        <?php if (count($taken) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Titel</th>
                        <th>Afdeling</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($taken as $taak): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($taak['titel']); ?></td>
                            <td><?php echo htmlspecialchars($taak['afdeling']); ?></td>
                            <td><?php echo htmlspecialchars($taak['status']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Er zijn geen actieve taken.</p>
        <?php endif; ?>
    </main>

    <footer>
        &copy; 2025 Developer Land Takenbord.
    </footer>
</body>
</html>