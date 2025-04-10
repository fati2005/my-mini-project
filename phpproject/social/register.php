<?php session_start();
include 'config.php';
$error = '';
 // Le code à l'intérieur s'exécute uniquement si la requête est de type POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = mysqli_real_escape_string($conn, $_POST["nom"]);
    $prenom = mysqli_real_escape_string($conn, $_POST["prenom"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $profession = mysqli_real_escape_string($conn, $_POST["profession"]);

    // Vérifier si l'email existe déjà
    $checkEmail = "SELECT id FROM users WHERE email = '$email'";
    $res = mysqli_query($conn, $checkEmail);

    if (mysqli_num_rows($res) > 0) {
        $error = "Cet email est déjà utilisé.";
    } else {
        // Gérer l'upload de l'image
$imageName = "ami1.jpg"; 
if (!empty($_FILES["image"]["name"])) {
    $imageName = time() . "_" . basename($_FILES["image"]["name"]);
    $targetDir = "images/";  
    $targetFile = $targetDir . $imageName;

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
      
    } else {
        $imageName = "default.jpg"; 
    }
}


        $sql = "INSERT INTO users (nom, prenom, email, password, profession, image) 
                VALUES ('$nom', '$prenom', '$email', '$password', '$profession', '$imageName')";
        if (mysqli_query($conn, $sql)) {
            header("Location: login.php");
            exit();
        } else {
            $error = "Erreur : " . mysqli_error($conn);
        }
    }
}


?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Créer un compte - Minisocial</title>
  <!-- Police Google Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap">
  
  <!-- Icônes Font Awesome -->
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
  />
  
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }
    body {
      font-family: 'Poppins', sans-serif;
      background: #f0f0f0;
      min-height: 90vh;
      margin: 0;
      color:  #f0f0f0;
    }
    
   
    .page-wrapper {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 200vh;
      padding: 20px;
    }
  
    .container {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  width: 100%;
}
    .right-side {
      width: 60%;
      background-color: #ffffff; 
      color: #ffffff;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      flex-basis: 40%; 
      padding: 50px;
    }
    .left-side .logo {
      max-width: 150px; 
      height: auto;
      margin-bottom: 20px;
    }
    .left-side h2 {
      font-size: 28px;
      margin-bottom: 15px;
    }
    .left-side p {
      font-size: 15px;
      line-height: 1.5;
      margin-bottom: 25px;
    }
    .left-side a.btn {
      display: inline-block;
      padding: 12px 30px;
      background: transparent;
      color: #fff;
      border: 2px solid #fff;
      border-radius: 30px;
      text-decoration: none;
      font-weight: 600;
      transition: 0.3s;
    }
    .register-left a.btn:hover {
      background: #fff;
      color: #2BA18E;
    }

    .left-side {
      width: 40%;
      background-color: #2BA18E;
      display: flex;
      flex-direction: column;
      justify-content: center;
      flex-basis: 35%; 
      padding: 50px;
    }
    .right-side h2 {
      font-size: 28px;
      margin-bottom: 15px;
      color: #2BA18E;
    }
    .right-side p {
      font-size: 14px;
      margin-bottom: 25px;
      color: #666;
    }

   
    form {
      width: 100%;
      max-width: 400px; 
      display: flex;
      flex-direction: column;
    }
    .input-group {
      display: flex;
      align-items: center;
      margin-bottom: 15px;
      padding: 10px 15px;
      background: #f9f9f9;
      border: 1px solid #ccc;
      border-radius: 5px;
    }
    .input-group i {
      margin-right: 10px;
      color: #888;
    }
    .input-group input {
      border: none;
      background: transparent;
      outline: none;
      width: 100%;
      font-size: 14px;
    }

   
    button.btn {
      padding: 12px;
      background: #2BA18E;
      color: #fff;
      border: none;
      border-radius: 30px;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      transition: 0.3s;
    }
    button.btn:hover {
      background:  #f9f9f9;
    }
    .logo {
  
  max-width: 700px;
  height: auto;
}


    
    @media (max-width: 600px) {
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
        <h2>Bon retour !</h2>
        <p>Pour rester connecté avec nous,<br>
           veuillez vous identifier avec vos informations personnelles</p>
        <a href="login.php" class="btn">Se connecter</a>
      </div>

      
      <div class="right-side">
        <h2>Créer un compte</h2>
        <p>ou utilisez votre adresse e-mail pour vous inscrire :</p>
        <form method="POST"  enctype="multipart/form-data">
          <div class="input-group">
            <i class="fas fa-user"></i>
            <input type="text" name="nom" placeholder="Nom" required>
          </div>
          <div class="input-group">
            <i class="fas fa-user"></i>
            <input type="text" name="prenom" placeholder="Prénom" required>
          </div>
          <div class="input-group">
            <i class="fas fa-envelope"></i>
            <input type="email" name="email" placeholder="Email" required>
          </div>
          <div class="input-group">
            <i class="fas fa-lock"></i>
            <input type="password" name="password" placeholder="Mot de passe" required>
          </div>
          <div class="input-group">
            <i class="fas fa-briefcase"></i>
            <input type="text" name="profession" placeholder="Profession" required>
          </div>
          <div class="input-group">
        <i class="fas fa-image"></i>
        <input type="file" name="image">
    </div>
          <button type="submit" class="btn">S'inscrire</button>
        </form>
      </div>
    </div>
  </div>
</body>
</html>


