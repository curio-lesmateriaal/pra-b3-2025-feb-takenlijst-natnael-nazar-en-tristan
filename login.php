<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taakbord</title>
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/main.css">
    
    
    <?php require_once 'head.php'; ?>
</head>
<body>
    <div class="container">
    <h1>Login</h1>
    <form action="<?php echo $base_url;?> /app/http/Controllers/takenlijstController.php">
        <div class="form-group">
            <input type="text" name="user" id="user" placeholder="Username" class="form-input">
        </div>
        <div class="form-group">
            <input type="text" name="password" id="password" placeholder="Password" class="form-input">
        </div>
        <input type="submit" value="login">
        </div>
        </div>
        </div>
    </form>
    </div>
</body>