<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: ../login.php');
    exit;
}

require_once 'conn.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM taken WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
}

header('Location: ../takenlijst.php');
exit;
?>