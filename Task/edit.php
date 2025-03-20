<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: ../login.php');
    exit;
}

require_once __DIR__ . '/../backend/conn.php';

// Stap 2: Schrijf de query met placeholders
$query = "SELECT * FROM taken WHERE id = :id";

// Stap 3: Zet om naar prepared statement
$statement = $conn->prepare($query);

// Stap 4: Voer het statement uit met de waarden
$statement->execute([
    'id' => $_GET['id']
]);

// Stap 5: Haal het resultaat op
$taak = $statement->fetch();

if (!$taak) {
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taak Bewerken</title>
    <link rel="stylesheet" href="../css/main.css">
</head>
<body>
    <header>
        <h1>Taak Bewerken</h1>
        <a href="index.php" class="button">Terug</a>
    </header>

    <form action="../app/http/Controllers/TaskController.php" method="POST">
        <input type="hidden" name="action" value="edit">
        <input type="hidden" name="id" value="<?php echo $taak['id']; ?>">
        
        <div>
            <label for="titel">Titel:</label>
            <input type="text" name="titel" id="titel" value="<?php echo $taak['titel']; ?>" required>
        </div>

        <div>
            <label for="beschrijving">Beschrijving:</label>
            <textarea name="beschrijving" id="beschrijving"><?php echo $taak['beschrijving']; ?></textarea>
        </div>

        <div>
            <label for="afdeling">Afdeling:</label>
            <select name="afdeling" id="afdeling" required>
                <option value="personeel" <?php echo $taak['afdeling'] == 'personeel' ? 'selected' : ''; ?>>Personeel</option>
                <option value="horeca" <?php echo $taak['afdeling'] == 'horeca' ? 'selected' : ''; ?>>Horeca</option>
                <option value="techniek" <?php echo $taak['afdeling'] == 'techniek' ? 'selected' : ''; ?>>Techniek</option>
                <option value="inkoop" <?php echo $taak['afdeling'] == 'inkoop' ? 'selected' : ''; ?>>Inkoop</option>
                <option value="groen" <?php echo $taak['afdeling'] == 'groen' ? 'selected' : ''; ?>>Groen</option>
            </select>
        </div>

        <div>
            <label for="status">Status:</label>
            <select name="status" id="status" required>
                <option value="todo" <?php echo $taak['status'] == 'todo' ? 'selected' : ''; ?>>Te doen</option>
                <option value="in_progress" <?php echo $taak['status'] == 'in_progress' ? 'selected' : ''; ?>>In uitvoering</option>
                <option value="done" <?php echo $taak['status'] == 'done' ? 'selected' : ''; ?>>Voltooid</option>
            </select>
        </div>

        <div>
            <label for="deadline">Deadline:</label>
            <input type="date" name="deadline" id="deadline" value="<?php echo $taak['deadline']; ?>" required>
        </div>

        <button type="submit">Opslaan</button>
    </form>
</body>
</html> 