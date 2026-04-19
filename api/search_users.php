<?php
error_reporting(0);
ini_set('display_errors', 0);
require '../config.php';
session_start();
header('Content-Type: application/json');
$uid = $_SESSION['user_id'];
// Exclude self, existing friends, and users with pending request
$stmt = $pdo->prepare("SELECT id, fullname, avatar FROM users WHERE id != ? AND id NOT IN (SELECT from_user FROM friend_requests WHERE to_user = ? UNION SELECT to_user FROM friend_requests WHERE from_user = ?)");
$stmt->execute([$uid, $uid, $uid]);
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
?>