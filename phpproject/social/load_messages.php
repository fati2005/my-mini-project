<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id']) || !isset($_GET['receiver_id'])) {
    echo json_encode([]);
    exit();
}

$user_id = $_SESSION['user_id'];
$friend_id = intval($_GET['receiver_id']);

$sql = "SELECT * FROM messages 
        WHERE (sender_id = $user_id AND receiver_id = $friend_id)
        OR (sender_id = $friend_id AND receiver_id = $user_id)
        ORDER BY created_at ASC";

$res = mysqli_query($conn, $sql);
$messages = [];
while ($row = mysqli_fetch_assoc($res)) {
    $messages[] = $row;
}
echo json_encode($messages);
