<?php
error_reporting(0);
ini_set('display_errors', 0);

require '../config.php';
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    echo json_encode(['success' => false, 'error' => 'No data received']);
    exit;
}

$fullname = trim($data['fullname'] ?? '');
$username = trim($data['username'] ?? '');
$email = trim($data['email'] ?? '');
$password = password_hash($data['password'], PASSWORD_DEFAULT);

if (empty($fullname) || empty($username) || empty($email) || empty($data['password'])) {
    echo json_encode(['success' => false, 'error' => 'All fields are required']);
    exit;
}

try {
    $stmt = $pdo->prepare("INSERT INTO users (fullname, username, email, password) VALUES (?, ?, ?, ?)");
    $stmt->execute([$fullname, $username, $email, $password]);
    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => 'Username or email already exists']);
}
?>