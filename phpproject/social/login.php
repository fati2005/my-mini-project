<?php
session_start();
include 'config.php';

$error = '';
$conn = mysqli_connect("localhost", "root", "", "minisocial", 4306);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $password = $_POST["password"];

   
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Vérifier le mot de passe avec password_verify
        if (password_verify($password, $row['password'])) {
            // Stocker les infos en session
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['prenom'] = $row['prenom'];
            $_SESSION['user_image'] = $row['image'];

           
            header("Location: index.php");
            exit();
        } else {
            $error = "Mot de passe incorrect.";
        }
    } else {
        $error = "Utilisateur non trouvé.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Se connecter au minisocial</title>
 
  
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: #f0f0f0;
      min-height: 100vh;
      margin: 0;
    }

 
    .container {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      width: 100%;
    }

   
    .left-side {
      width: 40%;
      background-color: #FFFFFF;
      display: flex;
      flex-direction: column;
      justify-content: center;
      flex-basis: 35%;
      padding: 40px;
    }

   
    form {
      display: flex;
      flex-direction: column;
      gap: 15px;
    }

    form input {
      padding: 12px;
      border: 1px solid #ccc;
      border-radius: 4px;
      font-size: 14px;
    }

    .error {
      color: red;
      margin-bottom: 10px;
    }
    .or-text {
      padding-top: 5px;
      margin-top: 5px;
    }

   
    button[type="submit"] {
      background-color: #2BA18E;
      color: #fff;
      border: none;
      cursor: pointer;
      padding: 12px;
      border-radius: 4px;
      font-size: 16px;
      font-weight: 600;
      transition: background-color 0.3s;
    }

    button[type="submit"]:hover {
      background-color: #249B84;
    }

    
    .signup-text {
      margin-top: 20px;
      font-size: 14px;
      color: #666;
    }
    .logo {
      max-width: 300px;
      height: auto;
    }

    .signup-text a {
      color: rgb(198, 225, 221);
      text-decoration: none;
      font-weight: 600;
    }

    .signup-text a:hover {
      text-decoration: underline;
    }

   
    .right-side {
      width: 70%;
      background-color: #2BA18E; 
      color: #ffffff;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      flex-basis: 40%; 
      padding: 150px;
    }

    .right-side h2 {
      font-size: 36px;
      margin-bottom: 20px;
      font-weight: 600;
    }

    .right-side p {
      font-size: 16px;
      margin-bottom: 40px;
      line-height: 1.5;
      text-align: center;
    }

    .signup-btn {
      background-color: transparent;
      border: 2px solid #ffffff;
      color: #ffffff;
      padding: 15px 30px;
      border-radius: 4px;
      font-size: 16px;
      text-decoration: none;
      transition: 0.3s;
      font-weight: 600;
    }

    .signup-btn:hover {
      background-color: #ffffff;
      color: #2BA18E;
    }

   
    @media (max-width: 768px) {
      .container {
        flex-direction: column;
      }
      .left-side, .right-side {
        width: 100%;
      }
    }
  </style>
</head>
<body>

<div class="container">

  <div class="left-side">
    <img src="talk.jpg" alt="minisocial" class="logo"> 
    <p class="or-text">ou utilisez votre compte e-mail :</p>

 
    <?php if (!empty($error)): ?>
      <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>

    <form method="POST">
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Mot de passe" required>
      <button type="submit">Se connecter</button>
    </form>

    <p class="signup-text">
      Pas encore inscrit ? <a href="register.php">Créer un compte</a>
    </p>
  </div>

  
  <div class="right-side">
    <h2>Bonjour, ami(e)!</h2>
    <p>Entrez vos informations personnelles et commencez votre aventure avec nous.</p>
    <a href="register.php" class="signup-btn">S’inscrire</a>
  </div>
</div>

</body>
</html>
