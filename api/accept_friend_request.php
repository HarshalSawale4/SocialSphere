<?php
error_reporting(0);
ini_set('display_errors', 0);
require '../config.php';
session_start();
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);
$req_id = $data['request_id'];
$stmt = $pdo->prepare("UPDATE friend_requests SET status='accepted' WHERE id = ? AND to_user = ?");
$stmt->execute([$req_id, $_SESSION['user_id']]);
echo json_encode(['success' => true]);
?>