<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: ../../../login.php');
    exit;
}

//  Pak de databaseverbinding erbij
require_once __DIR__ . '/../../../backend/conn.php';

// Haal de actie op
$action = $_POST['action'];


if ($action == 'create') {
    //  Schrijf de query met placeholders
    $query = "INSERT INTO taken (titel, beschrijving, afdeling, deadline, status) 
              VALUES (:titel, :beschrijving, :afdeling, :deadline, :status)";

    //  Zet om naar prepared statement
    $statement = $conn->prepare($query);

    //  Voer het statement uit met de waarden
    $statement->execute([
        'titel' => $_POST['titel'],
        'beschrijving' => $_POST['beschrijving'],
        'afdeling' => $_POST['afdeling'],
        'deadline' => $_POST['deadline'],
        'status' => 'todo'
    ]);

    header("Location: ../../../Task/index.php");
}

// EDIT
if ($action == 'edit') {
    // Stap 2: Schrijf de query met placeholders
    $query = "UPDATE taken 
              SET titel = :titel,
                  beschrijving = :beschrijving,
                  afdeling = :afdeling,
                  status = :status,
                  deadline = :deadline
              WHERE id = :id";

    // Stap 3: Zet om naar prepared statement
    $statement = $conn->prepare($query);

    // Stap 4: Voer het statement uit met de waarden
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

// DELETE
if ($action == 'delete') {
    // Stap 2: Schrijf de query met placeholders
    $query = "DELETE FROM taken WHERE id = :id";

    // Stap 3: Zet om naar prepared statement
    $statement = $conn->prepare($query);

    // Stap 4: Voer het statement uit met de waarden
    $statement->execute([
        'id' => $_POST['taak_id']
    ]);

    header("Location: ../../../Task/index.php");
}
?>        