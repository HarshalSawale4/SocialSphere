<?php
error_reporting(0);
ini_set('display_errors', 0);
require '../config.php';
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'Not logged in']);
    exit;
}

$uid = $_SESSION['user_id'];

if ($_FILES['avatar']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['success' => false, 'error' => 'Upload failed']);
    exit;
}

$allowed = ['image/jpeg', 'image/png', 'image/jpg'];
if (!in_array($_FILES['avatar']['type'], $allowed)) {
    echo json_encode(['success' => false, 'error' => 'Only JPG/PNG allowed']);
    exit;
}

$ext = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
$filename = 'avatar_' . $uid . '_' . time() . '.' . $ext;
$uploadDir = '../uploads/';
if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

$target = $uploadDir . $filename;
if (move_uploaded_file($_FILES['avatar']['tmp_name'], $target)) {
    $avatarPath = 'uploads/' . $filename;
    $stmt = $pdo->prepare("UPDATE users SET avatar = ? WHERE id = ?");
    $stmt->execute([$avatarPath, $uid]);
    echo json_encode(['success' => true, 'avatar' => $avatarPath]);
} else {
    echo json_encode(['success' => false, 'error' => 'Failed to move file']);
}
?>