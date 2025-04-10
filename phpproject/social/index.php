<?php 
session_start();
include 'config.php';
include 'messaging.php';


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Requête pour récupérer les posts
$sql_posts = "
    SELECT p.*,
           u.prenom, u.nom, u.image AS user_image,
           (SELECT COUNT(*) FROM likes WHERE post_id = p.id AND type = 'like') AS likes_count,
           (SELECT COUNT(*) FROM likes WHERE post_id = p.id AND type = 'dislike') AS dislikes_count,
           (SELECT COUNT(*) FROM comments WHERE post_id = p.id) AS comments_count
    FROM posts p
    JOIN users u ON p.user_id = u.id
    WHERE p.user_id = $user_id
       OR p.user_id IN (
          SELECT CASE 
              WHEN sender_id = $user_id THEN receiver_id
              ELSE sender_id
          END
          FROM invitations
          WHERE (sender_id = $user_id OR receiver_id = $user_id)
            AND status = 'accepted'
       )
    ORDER BY p.created_at DESC
";
$result_posts = mysqli_query($conn, $sql_posts);
include 'navbar.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>MiniSocial</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f0f9f4;
            margin: 0;
            padding: 60px 0 0;
            color: #333;
        }
        .main-content { max-width: 900px; margin: auto; padding: 20px; }
        .flash-message {
            background: #dff0d8;
            color: #3c763d;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 20px;
            text-align: center;
        }
        .post-form {
            background: #fff;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 30px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        }
        .post-form textarea, .post-form input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            font-size: 14px;
        }
        .post-form button {
            background: #3abf9a;
            color: #fff;
            padding: 8px 15px;
            border: none;
            border-radius: 4px;
            font-size: 14px;
            cursor: pointer;
        }
        .post-form button:hover { background: #249B84; }
        .posts-feed { display: flex; flex-direction: column; gap: 20px; }
        .post-item {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
            overflow: hidden;
        }
        .post-header {
            display: flex;
            align-items: center;
            padding: 10px;
            border-bottom: 1px solid #eee;
        }
        .post-header img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
            object-fit: cover;
            border: 2px solid #3abf9a;
        }
        .post-header strong { color: #3abf9a; }
        .post-header small { margin-left: auto; font-size: 12px; color: #777; }
        .post-content {
            padding: 10px;
            font-size: 14px;
            line-height: 1.5;
        }
        .post-content img {
            max-width: 100%;
            border: 2px solid #3abf9a;
            border-radius: 8px;
            margin-top: 10px;
            display: block;
        }
        .post-actions {
            display: flex;
            align-items: center;
            padding: 10px;
            border-top: 1px solid #eee;
            gap: 10px;
        }
        .action-btn {
            background: none;
            border: none;
            font-size: 18px;
            color: #3abf9a;
            cursor: pointer;
        }
        .action-btn span { margin-left: 3px; font-size: 14px; color: #333; }
        .post-comments {
            padding: 10px;
            border-top: 1px solid #eee;
            display: none;
        }
        .comment-item {
            background: #eefaf5;
            padding: 5px 10px;
            border-radius: 4px;
            margin-bottom: 5px;
            font-size: 13px;
        }
        .comment-form {
            display: flex;
            gap: 5px;
            margin-top: 10px;
        }
        .comment-form input[type="text"] {
            flex: 1;
            padding: 5px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .comment-form button {
            background: #3abf9a;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
        }
    </style>
</head>
<body>

<div class="main-content">
    <div class="flash-area"></div>

    <div class="post-form">
        <form id="postForm" method="POST" enctype="multipart/form-data">
            <textarea name="post_content" id="post_content" placeholder="Quoi de neuf ?" required></textarea>
            <input type="file" name="post_image" id="post_image" accept="image/*">
            <button type="submit" id="submitBtn">Publier</button>
        </form>
    </div>

    <div class="posts-feed">
        <?php while($post = mysqli_fetch_assoc($result_posts)): ?>
            <div class="post-item" data-postid="<?= $post['id']; ?>">
                <div class="post-header">
                    <img src="images/<?= htmlspecialchars($post['user_image'] ?? 'default.jpg'); ?>" alt="Profil">
                    <strong><?= htmlspecialchars($post['prenom'] . ' ' . $post['nom']); ?></strong>
                    <small><?= date("d/m/Y H:i", strtotime($post['created_at'])); ?></small>
                </div>
                <div class="post-content">
                    <p><?= nl2br(htmlspecialchars($post['content'])); ?></p>
                    <?php if (!empty($post['image'])): ?>
                        <img src="uploads/<?= htmlspecialchars($post['image']); ?>" alt="Image du post">
                    <?php endif; ?>
                </div>
                <div class="post-actions">
                    <button class="action-btn like-btn" data-postid="<?= $post['id']; ?>">
                        <i class="fas fa-thumbs-up"></i> <span class="like-count"><?= $post['likes_count']; ?></span>
                    </button>
                    <button class="action-btn dislike-btn" data-postid="<?= $post['id']; ?>">
                        <i class="fas fa-thumbs-down"></i> <span class="dislike-count"><?= $post['dislikes_count']; ?></span>
                    </button>
                    <button class="action-btn comment-btn toggle-comment" data-postid="<?= $post['id']; ?>">
                        <i class="fas fa-comment"></i> <span><?= $post['comments_count']; ?></span>
                    </button>
                </div>
                <div class="post-comments" id="comments-<?= $post['id']; ?>">
                    <?php
                    $post_id = $post['id'];
                    $sql_comments = "
                        SELECT c.*, u.prenom, u.nom
                        FROM comments c
                        JOIN users u ON c.user_id = u.id
                        WHERE c.post_id = $post_id
                        ORDER BY c.created_at ASC
                    ";
                    $result_comments = mysqli_query($conn, $sql_comments);
                    while($comment = mysqli_fetch_assoc($result_comments)):
                    ?>
                    <div class="comment-item">
                        <strong><?= htmlspecialchars($comment['prenom'] . ' ' . $comment['nom']); ?></strong> :
                        <?= nl2br(htmlspecialchars($comment['comment'])); ?>
                        <small><?= date("d/m/Y H:i", strtotime($comment['created_at'])); ?></small>
                    </div>
                    <?php endwhile; ?>
                    <form method="POST" action="add_comment.php" class="comment-form">
                        <input type="hidden" name="post_id" value="<?= $post['id']; ?>">
                        <input type="text" name="comment" placeholder="Votre commentaire" required>
                        <button type="submit">Envoyer</button>
                    </form>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function(){
    $(".posts-feed").on("click", ".toggle-comment", function(){
    let postId = $(this).data("postid");
    $("#comments-" + postId).slideToggle();
});



});

    $("#postForm").submit(function(e){
        e.preventDefault();
        let formData = new FormData(this);
        $.ajax({
            url: "add_post.php",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response){
                let res;
                try {
                    res = JSON.parse(response);
                } catch(e) {
                    alert("Erreur de format de réponse.");
                    return;
                }
                if(res.success){
                    $(".posts-feed").prepend(res.html);
                    $("#postForm")[0].reset();
                    $(".flash-area").html('<div class="flash-message">Post partagé avec succès !</div>');
                    setTimeout(() => $(".flash-message").fadeOut(), 3000);
                } else {
                    alert("Erreur : " + res.message);
                }
            },
            error: function(){
                alert("Erreur lors de la publication.");
            }
        });
    });

    $(".posts-feed").on("click", ".like-btn, .dislike-btn", function(){
        let btn = $(this);
        let postId = btn.data("postid");
        let action = btn.hasClass("like-btn") ? "like" : "dislike";
        $.post("like.php", { post_id: postId, action: action }, function(response){
            try {
                let res = JSON.parse(response);
                if(res.success){
                    btn.closest(".post-item").find(".like-count").text(res.likes);
                    btn.closest(".post-item").find(".dislike-count").text(res.dislikes);
                }
            } catch(e){
                alert("Réponse serveur invalide.");
            }
        });
    });

    $(".posts-feed").on("submit", ".comment-form", function(e){
        e.preventDefault();
        let form = $(this);
        $.post("add_comment.php", form.serialize(), function(response){
            if(response.success){
                $("#comments-" + form.find("input[name='post_id']").val()).append(response.html);
                form.find("input[name='comment']").val("");
            } else {
                alert("Erreur : " + response.message);
            }
        }, "json");
    });

</script>
</body>
</html>
