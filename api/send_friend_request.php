<?php
error_reporting(0);
ini_set('display_errors', 0);
require '../config.php';
session_start();
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);
$to = $data['to_user'];
$from = $_SESSION['user_id'];
$stmt = $pdo->prepare("INSERT INTO friend_requests (from_user, to_user) VALUES (?, ?) ON DUPLICATE KEY UPDATE status='pending'");
$stmt->execute([$from, $to]);
echo json_encode(['success' => true]);
?>