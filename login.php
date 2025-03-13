<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Taakbord</title>
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
    <div class="container-login">
        <h1>Login</h1>
        <form action="app/http/Controllers/takenlijstController.php" method="post">
            <div class="form-group">
                <label for="user">Gebruikersnaam:</label>
                <input type="text" name="user" id="user" placeholder="Gebruikersnaam" class="form-input" required>
            </div>
            <div class="form-group">
                <label for="pass">Wachtwoord:</label>
                <input type="password" name="pass" id="pass" placeholder="Wachtwoord" class="form-input" required>
            </div>
            <div class="form-group">
                <input type="submit" value="Inloggen" class="button">
            </div>
        </form>
    </div>
</body>
</html>