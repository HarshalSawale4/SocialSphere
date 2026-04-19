<?php
error_reporting(0);
ini_set('display_errors', 0);
require '../config.php';
session_start();
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);
$content = $data['content'] ?? '';
$image_url = $data['image_url'] ?? '';
$uid = $_SESSION['user_id'];
$stmt = $pdo->prepare("INSERT INTO posts (user_id, content, image_url) VALUES (?, ?, ?)");
$stmt->execute([$uid, $content, $image_url]);
echo json_encode(['success' => true]);
?>