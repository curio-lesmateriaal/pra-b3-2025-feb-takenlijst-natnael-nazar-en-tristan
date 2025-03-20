<?php
require_once '../backend/conn.php'; 
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nieuwe Taak Toevoegen</title>
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="taakbord.css">

</head>
<body>
    <header>
        <h1>Nieuwe Taak Toevoegen</h1>
        <nav>
            <a href="index.php">Terug naar takenlijst</a>
        </nav>
    </header>

    <main>
        <h2>Voer de taakgegevens in</h2>
        <form action="../app/http/Controllers/takenlijstController.php" method="post">
            <div class="form-group">
                <label for="titel">Titel:</label>
                <input type="text" name="titel" id="titel" required class="form-input">
            </div>

            <div class="form-group">
                <label for="beschrijving">Beschrijving:</label>
                <textarea name="beschrijving" id="beschrijving" rows="4" class="form-input"></textarea>
            </div>

            <div class="form-group">
                <label for="afdeling">Afdeling:</label>
                <select name="afdeling" id="afdeling" required class="form-input">
                    <option value="personeel">Personeel</option>
                    <option value="horeca">Horeca</option>
                    <option value="techniek">Techniek</option>
                    <option value="inkoop">Inkoop</option>
                    <option value="klantenservice">Klantenservice</option>
                    <option value="groen">Groen</option>
                </select>
            </div>

            <div class="form-group">
                <label for="deadline">Deadline:</label>
                <input type="date" name="deadline" id="deadline" required class="form-input">
            </div>

            <div class="form-group">
                <input type="submit" value="Taak Toevoegen" class="button">
            </div>
        </form>
    </main>
</body>
</html>