<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$host = 'localhost';
$dbname = 'socialsphere_db';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
function getUserById($pdo, $id) {
    $stmt = $pdo->prepare("SELECT id, fullname, username, email, avatar, bio FROM users WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}
?>