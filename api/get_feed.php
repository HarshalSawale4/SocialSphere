<?php
error_reporting(0);
ini_set('display_errors', 0);
require '../config.php';
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['posts' => []]);
    exit;
}

$uid = $_SESSION['user_id'];
$since = isset($_GET['since']) ? (int)$_GET['since'] : 0;

// Get friends list
$friends = $pdo->prepare("SELECT from_user as friend FROM friend_requests WHERE to_user = ? AND status='accepted' UNION SELECT to_user FROM friend_requests WHERE from_user = ? AND status='accepted'");
$friends->execute([$uid, $uid]);
$friendIds = $friends->fetchAll(PDO::FETCH_COLUMN);
$friendIds[] = $uid;
$in = str_repeat('?,', count($friendIds) - 1) . '?';
$stmt = $pdo->prepare("SELECT p.*, u.fullname, u.avatar FROM posts p JOIN users u ON p.user_id = u.id WHERE p.user_id IN ($in) AND UNIX_TIMESTAMP(p.created_at) > ? ORDER BY p.created_at DESC");
$stmt->execute(array_merge($friendIds, [$since]));
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($posts as &$post) {
    $likes = $pdo->prepare("SELECT COUNT(*) FROM likes WHERE post_id = ?");
    $likes->execute([$post['id']]);
    $post['likes_count'] = $likes->fetchColumn();
    $liked = $pdo->prepare("SELECT 1 FROM likes WHERE post_id = ? AND user_id = ?");
    $liked->execute([$post['id'], $uid]);
    $post['liked_by_user'] = $liked->rowCount() > 0;
    $comments = $pdo->prepare("SELECT c.*, u.fullname FROM comments c JOIN users u ON c.user_id = u.id WHERE c.post_id = ? ORDER BY c.created_at");
    $comments->execute([$post['id']]);
    $post['comments'] = $comments->fetchAll();
}
echo json_encode(['posts' => $posts]);
?>