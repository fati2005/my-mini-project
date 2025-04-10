<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>MiniSocial</title>
    <link rel="stylesheet" href="style.css"> 
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script> <!-- Icônes -->
</head>
<body>

<header class="topbar">
    <div class="topbar-left">
        <h2 class="brand-logo">MiniSocial</h2>
    </div>
    <div class="topbar-center">
        <form action="search.php" method="GET">
            <input type="text" name="q" placeholder="Rechercher...">
        </form>
    </div>
    <div class="topbar-right">
        <?php if (isset($_SESSION['user_id'])): ?>
            <span class="user-name"><?php echo $_SESSION['prenom'] ?? 'User'; ?></span>
            
            <img 
                src="images/<?php echo $_SESSION['user_image'] ?? 'ami5.jpg'; ?>" 
                alt="Profil" 
                class="user-avatar"
            >
            <a href="logout.php" class="login-logout-btn">Logout</a>
        <?php else: ?>
            <a href="login.php" class="login-logout-btn">Login</a>
        <?php endif; ?>
    </div>
</header>

<div class="container">
    <aside class="sidebar-left">
        <nav class="menu">
            <ul>
                <li class="menu-item">
                    <a href="index.php"><i class="fas fa-home"></i> Home</a>
                </li>
                <li class="menu-item">
                    <a href="profile.php"><i class="fas fa-user"></i> Profil</a>
                </li>
                <li class="menu-item">
                    <a href="invitations.php"><i class="fas fa-user-plus"></i> Invitations</a>
                </li>
                <li class="menu-item">
                    <a href="messages.php"><i class="fas fa-envelope"></i> Messages</a>
                </li>
                <li class="menu-item">
                    <a href="amis.php"><i class="fas fa-users"></i> Amis</a>
                </li>
            </ul>
        </nav>
    </aside>

    <div class="main-content">
        
   
