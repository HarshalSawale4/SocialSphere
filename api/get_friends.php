<?php
error_reporting(0);
ini_set('display_errors', 0);
require '../config.php';
session_start();
header('Content-Type: application/json');
$uid = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT u.id, u.fullname, u.avatar FROM users u WHERE u.id IN (SELECT from_user FROM friend_requests WHERE to_user = ? AND status='accepted' UNION SELECT to_user FROM friend_requests WHERE from_user = ? AND status='accepted')");
$stmt->execute([$uid, $uid]);
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
?>