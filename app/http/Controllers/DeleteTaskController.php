<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: ../../../login.php');
    exit;
}

require_once '../../../backend/conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['taak_id'])) {
    $taakId = $_POST['taak_id'];


    $query = "DELETE FROM taken WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->execute(['id' => $taakId]);

    $referer = $_SERVER['HTTP_REFERER']; 
    if (strpos($referer, 'done.php') !== false) {
        header('Location: ../../../Task/done.php');
    } else {
        header('Location: ../../../Task/index.php');
    }
    exit;
} else {
    header('Location: ../../../Task/index.php');
    exit;
}
?>