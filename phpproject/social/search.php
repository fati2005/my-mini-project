<?php
session_start();
include 'config.php'; 

// Vérification si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recherche</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { width: 50%; margin: auto; text-align: center; }
        input { padding: 8px; width: 60%; }
        button { padding: 8px; background-color: green; color: white; border: none; cursor: pointer; }
        .profile { margin-top: 20px; border: 1px solid #ccc; padding: 10px; }
        img { width: 80px; height: 80px; border-radius: 50%; object-fit: cover; }
    </style>
</head>
<body>

<div class="container">
    <h1>Recherche de profils</h1>

   
    <form action="search.php" method="GET">
        <input type="text" name="q" placeholder="Rechercher un prénom..." required>
        <button type="submit">Rechercher</button>
    </form>

    <?php
    if (isset($_GET['q']) && !empty($_GET['q'])) {
        $search = mysqli_real_escape_string($conn, $_GET['q']);

        $sql = "
    SELECT * FROM users
    WHERE prenom LIKE '$search%'
    ORDER BY prenom ASC
";

        $result = mysqli_query($conn, $sql);

        echo "<h2>Résultats pour : " . htmlspecialchars($search) . "</h2>";

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
               
                $image = "images/" . $row['image']; 
                if (!file_exists($image) || empty($row['image'])) {
                    $image = "images/default.jpg"; 
                }

                echo "<div class='profile'>";
                echo "<img src='$image' alt='Photo de profil'>";
                echo "<p><strong>" . htmlspecialchars($row['prenom'] . " " . $row['nom']) . "</strong></p>";
                echo "</div>";
            }
        } else {
            echo "<p>Aucun résultat trouvé.</p>";
        }
    }
    ?>
</div>

</body>
</html>
