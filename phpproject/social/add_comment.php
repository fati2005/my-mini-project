<?php
session_start();
include 'config.php';

if(!isset($_SESSION['user_id'])){
    echo json_encode(['success'=>false, 'message'=>'Utilisateur non connecté']);
    exit();
}

$post_id = intval($_POST['post_id']);
$comment_text = mysqli_real_escape_string($conn, $_POST['comment']);
$user_id = $_SESSION['user_id'];

$sql = "INSERT INTO comments (post_id, user_id, comment, created_at) VALUES ($post_id, $user_id, '$comment_text', NOW())";
if(mysqli_query($conn, $sql)){
    $comment_id = mysqli_insert_id($conn);
    // Récupérer le commentaire pour générer le HTML
    $sql_comment = "SELECT c.*, u.prenom, u.nom 
                    FROM comments c 
                    JOIN users u ON c.user_id = u.id 
                    WHERE c.id = $comment_id";
    $result_comment = mysqli_query($conn, $sql_comment);
    $comment = mysqli_fetch_assoc($result_comment);
    ob_start();
    ?>
    <div class="comment-item">
        <strong><?php echo htmlspecialchars($comment['prenom'] . ' ' . $comment['nom']); ?></strong> : 
        <?php echo nl2br(htmlspecialchars($comment['comment'])); ?>
        <small><?php echo date("d/m/Y H:i", strtotime($comment['created_at'])); ?></small>
    </div>
    <?php
    $html = ob_get_clean();
    echo json_encode(['success'=>true, 'html'=>$html]);
} else {
    echo json_encode(['success'=>false, 'message'=>'Erreur lors de l\'ajout du commentaire']);
}
?>
