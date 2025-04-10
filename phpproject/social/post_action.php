<?php
session_start();
include 'config.php';
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['content'])){
    $user_id = $_SESSION['user_id'];
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $sql = "INSERT INTO posts (user_id, content, created_at) VALUES ($user_id, '$content', NOW())";
    if(mysqli_query($conn, $sql)){
        echo "Success";
    } else {
        echo "Erreur: " . mysqli_error($conn);
    }
} else {
    echo "Requête invalide.";
}
?>
