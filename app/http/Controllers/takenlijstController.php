<?php
session_start();
require_once '../../../backend/conn.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titel = $_POST['titel'];
    $beschrijving = $_POST['beschrijving'];
    $afdeling = $_POST['afdeling'];
    $deadline = $_POST['deadline'];

    
    $query = "INSERT INTO taken (titel, beschrijving, afdeling, status, created_at, deadline) VALUES (:titel, :beschrijving, :afdeling, 'open', NOW(), :deadline)";
    $stmt = $conn->prepare($query);
    $stmt->execute([
        ':titel' => $titel,
        ':beschrijving' => $beschrijving,
        ':afdeling' => $afdeling,
        ':deadline' => $deadline 
    ]);

    header('Location: ../../../task/index.php');
    exit;
} else {
    echo "Ongeldige aanvraag.";
}
?>