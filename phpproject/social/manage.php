<?php
session_start();
include 'config.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['invitation_id'], $_POST['action'])) {
    $invitation_id = intval($_POST['invitation_id']);
    $user_id = $_SESSION['user_id'];
    $action = $_POST['action'];
    if ($action == 'accept') {
        $sql_update = "UPDATE invitations SET status='accepted' WHERE id = ? AND receiver_id = ?";
    } elseif ($action == 'refuse') {
        $sql_update = "UPDATE invitations SET status='refused' WHERE id = ? AND receiver_id = ?";
    } else {
        die("Action invalide.");
    }
    $stmt = mysqli_prepare($conn, $sql_update);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ii", $invitation_id, $user_id);
        if (mysqli_stmt_execute($stmt)) {
            header("Location: invitations.php");
            exit();
        } else {
            die(" Erreur lors de la mise à jour: " . mysqli_stmt_error($stmt));
        }
    } else {
        die(" Erreur lors de la préparation: " . mysqli_error($conn));
    }
} else {
    header("Location: invitations.php");
    exit();
}
?>
