<?php
// Disable error output to ensure clean JSON
error_reporting(0);
ini_set('display_errors', 0);

require '../config.php';  // config.php already starts the session
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$data = json_decode(file_get_contents('php://input'), true);

// Check if data was received
if (!$data || !isset($data['login']) || !isset($data['password'])) {
    echo json_encode(['success' => false, 'error' => 'Missing login data']);
    exit;
}

$login = trim($data['login']);
$password = $data['password'];

$stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? OR username = ?");
$stmt->execute([$login, $login]);
$user = $stmt->fetch();

if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    echo json_encode(['success' => true, 'user' => getUserById($pdo, $user['id'])]);
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid credentials']);
}
?>