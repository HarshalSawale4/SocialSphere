<?php
error_reporting(0);
require '../config.php';
session_start();
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);
$with_user = $data['with_user'];
$uid = $_SESSION['user_id'];
$stmt = $pdo->prepare("UPDATE messages SET is_read = 1 WHERE from_user = ? AND to_user = ?");
$stmt->execute([$with_user, $uid]);
echo json_encode(['success' => true]);
?>