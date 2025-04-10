<?php
session_start();
header('Content-Type: application/json');

include 'config.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode([]);
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT u.id, u.prenom, u.nom, u.image 
        FROM invitations i
        JOIN users u ON (
            (i.sender_id = u.id AND i.receiver_id = ?)
            OR (i.receiver_id = u.id AND i.sender_id = ?)
        )
        WHERE i.status = 'accepted' AND u.id != ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iii", $user_id, $user_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

$friends = [];
while ($row = $result->fetch_assoc()) {
    $friends[] = [
        'id' => $row['id'],
        'prenom' => $row['prenom'],
        'nom' => $row['nom'],
        'image' => $row['image'] ?? 'default.jpg'
    ];
}

echo json_encode($friends);
