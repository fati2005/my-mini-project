<?php 
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Utilisateur non connecté']);
    exit();
}

$post_id = intval($_POST['post_id']);
$user_id = $_SESSION['user_id'];
$action = isset($_POST['action']) ? $_POST['action'] : '';

// Vérifier que l'action est valide
if ($action !== 'like' && $action !== 'dislike') {
    echo json_encode(['success' => false, 'message' => 'Action invalide']);
    exit();
}

// Vérifier si l'utilisateur a déjà réagi avec ce type pour ce post
$sql_check = "SELECT * FROM likes WHERE post_id = $post_id AND user_id = $user_id AND type = '$action'";
$result_check = mysqli_query($conn, $sql_check);

if (mysqli_num_rows($result_check) > 0) {
    // Réaction déjà présente, on la retire
    $sql = "DELETE FROM likes WHERE post_id = $post_id AND user_id = $user_id AND type = '$action'";
    mysqli_query($conn, $sql);
    $reacted = false;
} else {
    // Si l'utilisateur a réagi avec le type opposé, on la supprime
    $opposite = ($action === 'like') ? 'dislike' : 'like';
    $sql_remove = "DELETE FROM likes WHERE post_id = $post_id AND user_id = $user_id AND type = '$opposite'";
    mysqli_query($conn, $sql_remove);
    
    // Ajout de la nouvelle réaction
    $sql = "INSERT INTO likes (post_id, user_id, type, created_at) VALUES ($post_id, $user_id, '$action', NOW())";
    mysqli_query($conn, $sql);
    $reacted = true;
}

// Récupérer le nouveau nombre de likes et dislikes
$sql_like_count = "SELECT COUNT(*) as like_count FROM likes WHERE post_id = $post_id AND type = 'like'";
$result_like_count = mysqli_query($conn, $sql_like_count);
$row_like = mysqli_fetch_assoc($result_like_count);

$sql_dislike_count = "SELECT COUNT(*) as dislike_count FROM likes WHERE post_id = $post_id AND type = 'dislike'";
$result_dislike_count = mysqli_query($conn, $sql_dislike_count);
$row_dislike = mysqli_fetch_assoc($result_dislike_count);

echo json_encode([
    'success'   => true, 
    'reacted'   => $reacted, 
    'likes'     => $row_like['like_count'],
    'dislikes'  => $row_dislike['dislike_count']
]);
?>
