<?php
error_reporting(0);
ini_set('display_errors', 0);
require '../config.php';
session_start();
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);
$post_id = $data['post_id'];
$uid = $_SESSION['user_id'];
$check = $pdo->prepare("SELECT * FROM likes WHERE post_id = ? AND user_id = ?");
$check->execute([$post_id, $uid]);
if ($check->rowCount()) {
    $pdo->prepare("DELETE FROM likes WHERE post_id = ? AND user_id = ?")->execute([$post_id, $uid]);
} else {
    $pdo->prepare("INSERT INTO likes (post_id, user_id) VALUES (?, ?)")->execute([$post_id, $uid]);
}
echo json_encode(['success' => true]);
?>