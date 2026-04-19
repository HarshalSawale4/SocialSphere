<?php
error_reporting(0);
ini_set('display_errors', 0);
require '../config.php';
session_start();
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);
$to = $data['to_user'];
$content = $data['content'];
$from = $_SESSION['user_id'];
$stmt = $pdo->prepare("INSERT INTO messages (from_user, to_user, content) VALUES (?, ?, ?)");
$stmt->execute([$from, $to, $content]);
echo json_encode(['success' => true]);
?>