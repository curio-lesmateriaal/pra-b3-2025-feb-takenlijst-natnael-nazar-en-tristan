<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
    <header>
    <h1 class="tekst-white">Login</h1>
        <a href="/" class="button">Home</a>
    </header>
    
    <form method="POST" action="/app/http/Controllers/LoginController.php">
        <div>
            <label for="user">Gebruikersnaam</label>
            <input type="text" name="user" id="user" required>
        </div>
        <div>
            <label for="pass">Wachtwoord</label>
            <input type="password" name="pass" id="pass" required>
        </div>
        <button type="submit">Login</button>
    </form>
</body>
</html>