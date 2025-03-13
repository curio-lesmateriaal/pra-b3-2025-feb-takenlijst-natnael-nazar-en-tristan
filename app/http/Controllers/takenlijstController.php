<?php
session_start();
require_once '../../../backend/conn.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titel = $_POST['titel'];
    $beschrijving = $_POST['beschrijving'];
    $afdeling = $_POST['afdeling'];

    // Invoegen in database
    $query = "INSERT INTO taken (titel, beschrijving, afdeling, status) VALUES (:titel, :beschrijving, :afdeling, 'open')";
    $stmt = $conn->prepare($query);
    $stmt->execute([
        ':titel' => $titel,
        ':beschrijving' => $beschrijving,
        ':afdeling' => $afdeling
    ]);

    
    header('Location: ../../../task/index.php');
    exit;
} else {
    echo "Ongeldige aanvraag.";
}
