<?php
error_reporting(0);
ini_set('display_errors', 0);
require '../config.php';
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['count' => 0]);
    exit;
}
$uid = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT COUNT(*) FROM messages WHERE to_user = ? AND is_read = 0");
$stmt->execute([$uid]);
$count = $stmt->fetchColumn();
echo json_encode(['count' => (int)$count]);
?>