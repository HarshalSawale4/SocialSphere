<?php
error_reporting(0);
ini_set('display_errors', 0);
require '../config.php';
session_start();
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$with_user = $data['with_user'];
$since = isset($data['since']) ? (int)$data['since'] : 0;
$uid = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT * FROM messages WHERE ((from_user = ? AND to_user = ?) OR (from_user = ? AND to_user = ?)) AND UNIX_TIMESTAMP(created_at) > ? ORDER BY created_at");
$stmt->execute([$uid, $with_user, $with_user, $uid, $since]);
echo json_encode(['messages' => $stmt->fetchAll(PDO::FETCH_ASSOC)]);
?>