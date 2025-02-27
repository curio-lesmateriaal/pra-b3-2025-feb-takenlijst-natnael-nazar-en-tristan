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
    <div class="container-login">
    <h1>Login</h1>
    <form action="<?php $base_url?>/app/http/Controllers/takenlijstController.php">
        <div class="form-group">
            <input type="text" name="user" id="user" placeholder="Username" class="form-input">
        </div>
        <div class="form-group">
            <input type="text" name="pass" id="pass" placeholder="Password" class="form-input">
        </div>
        <div class="Button">
        <input type="submit" value="Login">
</div>
        </div>
        </div>
    </form>
    </div>
</body>