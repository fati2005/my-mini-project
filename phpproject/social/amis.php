<?php
session_start();
include 'config.php';
include 'messaging.php';
?>
<?php include 'navbar.php'; ?>

<main>
  <div class="friends-container">
    <h2>Mes Amis</h2>
    <?php
    if (!isset($_SESSION['user_id'])) {
      header("Location: login.php");
      exit();
    }
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT u.* FROM invitations inv 
            JOIN users u ON (
                (inv.sender_id = u.id AND inv.receiver_id = $user_id)
                OR (inv.receiver_id = u.id AND inv.sender_id = $user_id)
            )
            WHERE inv.status = 'accepted'";
    $result = mysqli_query($conn, $sql);
    $friends = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $friends[] = $row;
    }
    if (count($friends) > 0):
    ?>
      <ul class="friends-list">
        <?php foreach ($friends as $friend): ?>
          <li class="friend-item">
            <img src="images/<?php echo $friend['image'] ?? 'ami7.jpg'; ?>" alt="Avatar" class="friend-avatar">
            <span class="friend-name"><?php echo $friend['prenom'] . ' ' . $friend['nom']; ?></span>
            <a href="messages.php?to=<?php echo $friend['id']; ?>" class="action-btn btn-message">
              <i class="fas fa-envelope"></i> Message
            </a>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php else: ?>
      <p>Vous n'avez pas encore d'amis.</p>
    <?php endif; ?>
  </div>
  
</main>

</div> 
</div> 
</body>
</html>
