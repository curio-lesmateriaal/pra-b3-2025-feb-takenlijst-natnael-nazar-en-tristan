<?php
session_start();
require_once '../../../backend/conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];

    $query = "DELETE FROM taken WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->execute([':id' => $id]);

    echo json_encode(['success' => true]);
    exit;
}

echo json_encode(['success' => false]);
