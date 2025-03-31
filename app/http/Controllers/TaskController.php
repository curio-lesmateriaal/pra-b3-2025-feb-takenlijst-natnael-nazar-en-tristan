<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: ../../../login.php');
    exit;
}

//1. Verbinding
require_once __DIR__ . '/../../../backend/conn.php';

//Variabelen vullen
$action = $_POST['action'];

// Haal user ID op
$userQuery = "SELECT id FROM users WHERE username = :username";
$userStmt = $conn->prepare($userQuery);
$userStmt->execute(['username' => $_SESSION['user']]);
$user = $userStmt->fetch();
$userId = $user['id'];

if ($action == 'create') {
    //2. Query
    $query = "INSERT INTO taken (titel, beschrijving, afdeling, deadline, status, user) 
              VALUES (:titel, :beschrijving, :afdeling, :deadline, :status, :user)";

    //3. Prepare
    $statement = $conn->prepare($query);

    //4. Execute
    $statement->execute([
        'titel' => $_POST['titel'],
        'beschrijving' => $_POST['beschrijving'],
        'afdeling' => $_POST['afdeling'],
        'deadline' => $_POST['deadline'],
        'status' => 'todo',
        'user' => $userId
    ]);

    header("Location: ../../../Task/index.php");
}

if ($action == 'edit') {
    //2. Query
    $query = "UPDATE taken 
              SET titel = :titel,
                  beschrijving = :beschrijving,
                  afdeling = :afdeling,
                  status = :status,
                  deadline = :deadline
              WHERE id = :id";

    //3. Prepare
    $statement = $conn->prepare($query);

    //4. Execute
    $statement->execute([
        'id' => $_POST['id'],
        'titel' => $_POST['titel'],
        'beschrijving' => $_POST['beschrijving'],
        'afdeling' => $_POST['afdeling'],
        'status' => $_POST['status'],
        'deadline' => $_POST['deadline']
    ]);

    if ($_POST['status'] == 'done') {
        header("Location: ../../../Task/done.php");
    } else {
        header("Location: ../../../Task/index.php");
    }
}

if ($action == 'delete') {
    //2. Query
    $query = "DELETE FROM taken WHERE id = :id";

    //3. Prepare
    $statement = $conn->prepare($query);

    //4. Execute
    $statement->execute([
        'id' => $_POST['taak_id']
    ]);

    header("Location: ../../../Task/index.php");
}
?>        