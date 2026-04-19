<?php
error_reporting(0);
ini_set('display_errors', 0);
require '../config.php';
session_start();
header('Content-Type: application/json');
$uid = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT fr.id, u.id as user_id, u.fullname, u.avatar FROM friend_requests fr JOIN users u ON fr.from_user = u.id WHERE fr.to_user = ? AND fr.status = 'pending'");
$stmt->execute([$uid]);
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
?>