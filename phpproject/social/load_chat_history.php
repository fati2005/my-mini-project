<?php
session_start();
include 'config.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode([]);
    exit;
}

$loggedInUserId = $_SESSION['user_id'];
$friend_id = isset($_GET['friend_id']) ? (int)$_GET['friend_id'] : 0;

// Récupération des messages entre l'utilisateur connecté et son ami, triés par ordre chronologique
$sql = "SELECT * FROM messages 
        WHERE (sender_id = $loggedInUserId AND receiver_id = $friend_id)
           OR (sender_id = $friend_id AND receiver_id = $loggedInUserId)
        ORDER BY created_at ASC";
$result = mysqli_query($conn, $sql);
$messages = [];
if($result){
    while ($row = mysqli_fetch_assoc($result)) {
        $messages[] = $row;
    }
}
echo json_encode($messages);
?>
