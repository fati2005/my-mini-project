<?php
session_start(); 
include 'config.php';
include 'messaging.php';


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); 
    exit(); 
}

// Récupère l'ID de l'utilisateur connecté depuis la session
$loggedInUserId = $_SESSION['user_id'];

// Récupère l'ID du profil à afficher depuis les paramètres GET de l'URL
// Si aucun ID n'est fourni, affiche le profil de l'utilisateur connecté
$profileId = isset($_GET['id']) ? intval($_GET['id']) : $loggedInUserId;

// Prépare une requête SQL pour récupérer les informations de l'utilisateur correspondant à $profileId
$sql = "SELECT * FROM users WHERE id = $profileId";
$result = mysqli_query($conn, $sql); // Exécute la requête
$profile = mysqli_fetch_assoc($result); // Récupère les données sous forme de tableau associatif

include 'navbar.php'; 
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Profil de <?php echo htmlspecialchars($profile['prenom'] . ' ' . $profile['nom']); ?></title>
  <link rel="stylesheet" href="style.css"> 
  <script src="script.js"></script> 
 
</head>
<body>
<main>
  <div class="profile-container">
    <div class="profile-card">
      <!-- Affiche l'image de profil de l'utilisateur ou une image par défaut si aucune n'est définie -->
      <img src="images/<?php echo htmlspecialchars($profile['image'] ?? 'ami3.jpg'); ?>" alt="Photo Profil" class="profile-card-avatar">
      <!-- Affiche le prénom et le nom de l'utilisateur -->
      <h3><?php echo htmlspecialchars($profile['prenom'] . ' ' . $profile['nom']); ?></h3>
      <!-- Affiche la profession de l'utilisateur -->
      <p class="profession"><?php echo htmlspecialchars($profile['profession']); ?></p>
      <!-- Affiche l'email de l'utilisateur -->
      <p>Email : <?php echo htmlspecialchars($profile['email']); ?></p>
    </div>
    <?php if ($loggedInUserId != $profileId): ?>
        <?php
          // Vérifie si une invitation existe déjà entre l'utilisateur connecté et le profil affiché
          $checkInviteSql = "SELECT status FROM invitations 
                             WHERE (sender_id = $loggedInUserId AND receiver_id = $profileId)
                                OR (sender_id = $profileId AND receiver_id = $loggedInUserId)";
          $inviteResult = mysqli_query($conn, $checkInviteSql);
        ?>
        <div class="invitation-section">
        <?php if (mysqli_num_rows($inviteResult) > 0): 
            $invite = mysqli_fetch_assoc($inviteResult);
            if ($invite['status'] == 'pending'): ?>
                <!-- Affiche un message si une invitation est en attente -->
                <p class="invite-status">Demande d'invitation envoyée et en attente.</p>
            <?php elseif ($invite['status'] == 'accepted'): ?>
                <!-- Affiche un message si les utilisateurs sont déjà amis -->
                <p class="invite-status">Vous êtes amis.</p>
            <?php elseif ($invite['status'] == 'refused'): ?>
                <!-- Affiche un bouton pour renvoyer une demande si l'invitation a été refusée -->
                <form action="send.php" method="POST">
                  <input type="hidden" name="receiver_id" value="<?php echo $profileId; ?>">
                  <button type="submit" class="friend-request-btn">Renvoyer demande</button>
                </form>
            <?php endif; 
          else: ?>
            <!-- Affiche un bouton pour envoyer une demande d'invitation si aucune n'existe -->
            <button class="friend-request-btn" id="sendInviteBtn" data-receiver="<?php echo $profileId; ?>">
              Envoyer demande d'invitation
            </button>
          <?php endif; ?>
        </div>
    <?php endif; ?>
  </div>
  <!-- Bouton d'ouverture/fermeture + fenêtre de chat -->
<div class="chat-container" id="chatContainer">
  <div class="chat-header" id="chatHeader">
    <span>Messenger</span>
    <button type="button" class="close-btn" id="closeBtn">X</button>
  </div>
  <div class="chat-body">
    <div class="messages" id="messages">
      <!-- Les messages reçus/envoyés s'afficheront ici -->
      <div class="message received">Salut !</div>
      <div class="message sent">Bonjour !</div>
    </div>
    <div class="chat-input">
      <input type="text" id="chatInputField" placeholder="Écrire un message...">
      <button type="button" id="sendBtn">Envoyer</button>
    </div>
  </div>
</div>

</main>
<script>
  // Ajoute un écouteur d'événements au bouton d'envoi d'invitation
  document.getElementById('sendInviteBtn') && document.getElementById('sendInviteBtn').addEventListener('click', function(){
    var receiverId = this.getAttribute('data-receiver');
    if(confirm("Voulez-vous envoyer une demande d'invitation ?")) {
      var form = document.createElement('form');
      form.method = 'POST';
      form.action = 'send.php';
      var input = document.createElement('input');
      input.type = 'hidden';
      input.name = 'receiver_id';
      input.value = receiverId;
      form.appendChild(input);
      document.body.appendChild(form);
      form.submit();
    }
  });
</script>
</body>
</html>
