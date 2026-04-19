<?php
error_reporting(0);
ini_set('display_errors', 0);
require '../config.php';
session_start();
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);
$post_id = $data['post_id'];
$content = $data['content'];
$uid = $_SESSION['user_id'];
$stmt = $pdo->prepare("INSERT INTO comments (post_id, user_id, content) VALUES (?, ?, ?)");
$stmt->execute([$post_id, $uid, $content]);
echo json_encode(['success' => true]);
?>