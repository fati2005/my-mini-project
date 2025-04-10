<?php
session_start();
include 'config.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$msgStatus = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $text = mysqli_real_escape_string($conn, $_POST["text"]);
    $user_id = $_SESSION['user_id'];
    $sql = "INSERT INTO messages (user_id, text) VALUES ($user_id, '$text')";
    if (mysqli_query($conn, $sql)) {
        $msgStatus = "Message envoyé !";
    } else {
        $msgStatus = "Erreur : " . mysqli_error($conn);
    }
}
// Récupérer les messages
$allMessages = [];
$sqlAll = "SELECT m.*, u.nom, u.prenom, m.created_at 
           FROM messages m 
           JOIN users u ON m.user_id = u.id 
           ORDER BY m.created_at DESC";
$resAll = mysqli_query($conn, $sqlAll);
while ($row = mysqli_fetch_assoc($resAll)) {
    $allMessages[] = $row;
}
include 'navbar.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Messagerie - MiniSocial</title>
  <link rel="stylesheet" href="style.css">
  
  <script src="script.js"></script>
</head>
<body>
<main>
    <div class="messages-container">
        <h2>Messages</h2>  
        <?php if ($msgStatus != ''): ?>
            <p><?php echo $msgStatus; ?></p>
        <?php endif; ?>
        <form method="POST">
            <textarea name="message" placeholder="Écrire un message..." required></textarea>
            <button type="submit" class="button">Envoyer</button>
        </form>
        <div class="message-list">
            <?php if (count($allMessages) > 0): ?>
                <?php foreach ($allMessages as $msg): ?>
                    <div class="message-item">
                        <p><strong><?php echo $msg['prenom'] . ' ' . $msg['nom']; ?></strong> (<?php echo $msg['created_at']; ?>)</p>
                        <p><?php echo $msg['text']; ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Aucun message.</p>
            <?php endif; ?>
        </div>
    </div>

<script>

  // Exemple d'envoi de message
  sendBtn.addEventListener('click', () => {
    const text = chatInput.value.trim();
    if (text !== '') {
      // On affiche le message dans la fenêtre
      const newMessage = document.createElement('div');
      newMessage.classList.add('text', 'sent');
      newMessage.textContent = text;
      messages.appendChild(newMessage);
      chatInput.value = '';

      // Faire défiler la zone de messages vers le bas
      messages.scrollTop = messages.scrollHeight;

      // ICI : on pourrait appeler une fonction AJAX ou WebSocket
      // pour envoyer ce message au serveur et l'enregistrer en BDD
    }
  });
</script>


</main>
</body>
</html>
