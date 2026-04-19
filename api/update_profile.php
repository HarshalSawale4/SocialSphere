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
$data = json_decode(file_get_contents('php://input'), true);

$fullname = trim($data['fullname'] ?? '');
$username = trim($data['username'] ?? '');
$email = trim($data['email'] ?? '');
$bio = trim($data['bio'] ?? '');
$newPassword = $data['password'] ?? '';

// Validate
if (empty($fullname) || empty($username) || empty($email)) {
    echo json_encode(['success' => false, 'error' => 'Full name, username and email are required']);
    exit;
}

// Check if username/email already taken by another user
$check = $pdo->prepare("SELECT id FROM users WHERE (username = ? OR email = ?) AND id != ?");
$check->execute([$username, $email, $uid]);
if ($check->rowCount() > 0) {
    echo json_encode(['success' => false, 'error' => 'Username or email already taken']);
    exit;
}

// Update query
$sql = "UPDATE users SET fullname = ?, username = ?, email = ?, bio = ?";
$params = [$fullname, $username, $email, $bio];

if (!empty($newPassword)) {
    $hashed = password_hash($newPassword, PASSWORD_DEFAULT);
    $sql .= ", password = ?";
    $params[] = $hashed;
}

$sql .= " WHERE id = ?";
$params[] = $uid;

$stmt = $pdo->prepare($sql);
if ($stmt->execute($params)) {
    // Return updated user data
    $updatedUser = getUserById($pdo, $uid);
    echo json_encode(['success' => true, 'user' => $updatedUser]);
} else {
    echo json_encode(['success' => false, 'error' => 'Update failed']);
}
?>