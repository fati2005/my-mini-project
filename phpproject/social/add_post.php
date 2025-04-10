<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Utilisateur non authentifié']);
    exit();
}

$user_id = $_SESSION['user_id'];
$content = isset($_POST['post_content']) ? trim($_POST['post_content']) : '';
$image = isset($_FILES['post_image']) ? $_FILES['post_image'] : null;

if (empty($content) && !$image) {
    echo json_encode(['success' => false, 'message' => 'Le contenu du post est vide']);
    exit();
}

// Sauvegarde de l'image si elle existe
$image_name = null;
if ($image && $image['error'] === 0) {
    $upload_dir = 'uploads/';
    $image_name = uniqid() . '-' . basename($image['name']);
    
    if (!move_uploaded_file($image['tmp_name'], $upload_dir . $image_name)) {
        echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'upload de l\'image']);
        exit();
    }
}

// Insertion du post dans la base de données
$sql = "INSERT INTO posts (user_id, content, image) VALUES (?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'iss', $user_id, $content, $image_name);
if (mysqli_stmt_execute($stmt)) {
    $post_id = mysqli_insert_id($conn);
    
    // Récupération du post avec les données nécessaires pour l'affichage
    $sql_post = "
        SELECT p.*, u.prenom, u.nom, u.image AS user_image,
               (SELECT COUNT(*) FROM likes WHERE post_id = p.id AND type = 'like') AS likes_count,
               (SELECT COUNT(*) FROM likes WHERE post_id = p.id AND type = 'dislike') AS dislikes_count,
               (SELECT COUNT(*) FROM comments WHERE post_id = p.id) AS comments_count
        FROM posts p
        JOIN users u ON p.user_id = u.id
        WHERE p.id = $post_id
    ";
    $result_post = mysqli_query($conn, $sql_post);
    $post = mysqli_fetch_assoc($result_post);

    // Construction du HTML du post à renvoyer en réponse
    ob_start();
    ?>
    <div class="post-item" data-postid="<?php echo $post['id']; ?>">
        <div class="post-header">
            <img src="images/<?php echo htmlspecialchars($post['user_image'] ?? 'default.jpg'); ?>" alt="User">
            <strong><?php echo htmlspecialchars($post['prenom'] . ' ' . $post['nom']); ?></strong>
            <small><?php echo date("d/m/Y H:i", strtotime($post['created_at'])); ?></small>
        </div>
        <div class="post-content">
            <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
            <?php if (!empty($post['image'])): ?>
                <img src="uploads/<?php echo htmlspecialchars($post['image']); ?>" alt="Photo du post">
            <?php endif; ?>
        </div>
        <div class="post-actions">
            <button class="action-btn like-btn" data-postid="<?php echo $post['id']; ?>" title="Like">
                <i class="fas fa-thumbs-up"></i>
                <span class="like-count"><?php echo $post['likes_count']; ?></span>
            </button>
            <button class="action-btn dislike-btn" data-postid="<?php echo $post['id']; ?>" title="Dislike">
                <i class="fas fa-thumbs-down"></i>
                <span class="dislike-count"><?php echo $post['dislikes_count']; ?></span>
            </button>
            <button class="action-btn comment-btn toggle-comment" data-postid="<?php echo $post['id']; ?>" title="Commenter">
                <i class="fas fa-comment"></i>
                <span><?php echo $post['comments_count']; ?></span>
            </button>
        </div>
        <div class="post-comments" id="comments-<?php echo $post['id']; ?>">
            <!-- Les commentaires du post seront ici -->
        </div>
    </div>
    <?php
    $html = ob_get_clean();

    // Réponse JSON
    echo json_encode([
        'success' => true,
        'html' => $html,
        'message' => 'Post publié avec succès !'
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'enregistrement du post']);
}
?>
