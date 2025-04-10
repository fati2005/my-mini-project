<?php
session_start();
include 'config.php';
if(!isset($_SESSION['user_id'])){
    echo "Veuillez vous connecter.";
    exit();
}
$user_id = $_SESSION['user_id'];
$friend_ids = [];
// Récupérer les identifiants des amis via les invitations acceptées
$sql_friends = "SELECT CASE WHEN sender_id = $user_id THEN receiver_id ELSE sender_id END AS friend_id 
                FROM invitations 
                WHERE (sender_id = $user_id OR receiver_id = $user_id) AND status = 'accepted'";
$result_friends = mysqli_query($conn, $sql_friends);
while($row = mysqli_fetch_assoc($result_friends)){
    $friend_ids[] = $row['friend_id'];
}
$friend_ids_str = implode(',', $friend_ids);
if($friend_ids_str != ""){
   $sql_posts = "SELECT p.*, u.prenom, u.nom, u.image 
                 FROM posts p 
                 JOIN users u ON p.user_id = u.id 
                 WHERE p.user_id IN ($friend_ids_str) OR p.user_id = $user_id 
                 ORDER BY p.created_at DESC";
} else {
   $sql_posts = "SELECT p.*, u.prenom, u.nom, u.image 
                 FROM posts p 
                 JOIN users u ON p.user_id = u.id 
                 WHERE p.user_id = $user_id 
                 ORDER BY p.created_at DESC";
}
$result_posts = mysqli_query($conn, $sql_posts);
if(mysqli_num_rows($result_posts) > 0){
    while($post = mysqli_fetch_assoc($result_posts)){
        // Comptage des likes pour ce post
        $sql_like = "SELECT COUNT(*) as likes_count FROM likes WHERE post_id = " . $post['id'];
        $res_like = mysqli_query($conn, $sql_like);
        $like_data = mysqli_fetch_assoc($res_like);
        $likes_count = $like_data['likes_count'];
        
        echo '<div class="post-container">';
            echo '<div class="post-header">';
                echo '<img src="images/' . ($post['image'] ?? 'ami7.jpg') . '" alt="Avatar">';
                echo '<strong>' . $post['prenom'] . ' ' . $post['nom'] . '</strong>';
                echo '<span style="margin-left:10px; color:#888; font-size:12px;">' . date("d/m/Y H:i", strtotime($post['created_at'])) . '</span>';
            echo '</div>';
            echo '<div class="post-content">' . htmlspecialchars($post['content']) . '</div>';
            echo '<div class="post-actions">';
                echo '<button class="btn-like" onclick="likePost(' . $post['id'] . ')"><i class="fas fa-thumbs-up"></i> Like</button>';
                echo '<span>' . $likes_count . ' Likes</span>';
            echo '</div>';
        echo '</div>';
    }
} else {
    echo "<p>Aucun post à afficher.</p>";
}
?>
