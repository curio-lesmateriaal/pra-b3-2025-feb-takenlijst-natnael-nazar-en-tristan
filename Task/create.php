<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: ../login.php');
    exit;
}

require_once __DIR__ . '/../backend/conn.php';
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nieuwe Taak</title>
    <link rel="stylesheet" href="../css/main.css">
</head>
<body>
    <header>
        <h1>Nieuwe Taak</h1>
        <a href="index.php" class="button">Terug</a>
    </header>

    <form action="../app/http/Controllers/TaskController.php" method="POST">
        <input type="hidden" name="action" value="create">
        
        <div>
            <label for="titel">Titel:</label>
            <input type="text" name="titel" id="titel" required>
        </div>

        <div>
            <label for="beschrijving">Beschrijving:</label>
            <textarea name="beschrijving" id="beschrijving"></textarea>
        </div>

        <div>
            <label for="afdeling">Afdeling:</label>
            <select name="afdeling" id="afdeling" required>
                <option value="personeel">Personeel</option>
                <option value="horeca">Horeca</option>
                <option value="techniek">Techniek</option>
                <option value="inkoop">Inkoop</option>
                <option value="groen">Groen</option>
            </select>
        </div>

        <div>
            <label for="deadline">Deadline:</label>
            <input type="date" name="deadline" id="deadline" required>
        </div>

        <button type="submit">Opslaan</button>
    </form>
</body>
</html>