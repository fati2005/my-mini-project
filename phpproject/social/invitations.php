<?php
session_start();
include 'config.php';
include 'navbar.php';
include 'messaging.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$user_id = $_SESSION['user_id'];
// Invitations reçues 
$sql_received = "SELECT inv.id, inv.date, u.prenom, u.nom 
                 FROM invitations inv 
                 JOIN users u ON inv.sender_id = u.id 
                 WHERE inv.receiver_id = $user_id AND inv.status = 'pending'";
$result_received = mysqli_query($conn, $sql_received);
// Invitations envoyées 
$sql_sent = "SELECT inv.id, inv.date, inv.status, u.prenom, u.nom 
             FROM invitations inv 
             JOIN users u ON inv.receiver_id = u.id 
             WHERE inv.sender_id = $user_id";
$result_sent = mysqli_query($conn, $sql_sent);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Invitations - MiniSocial</title>
  <link rel="stylesheet" href="style.css">
  <script src="script.js"></script>
  
  <style>
   
    .invitations-container { max-width: 800px; margin: 20px auto; padding: 15px; background: #fff; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
    .invitation-list, .history-list { list-style: none; padding: 0; }
    .invitation-item, .history-item { padding: 10px; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; align-items: center; }
    .actions form { display: inline; }
    .btn { border: none; padding: 8px 12px; cursor: pointer; border-radius: 4px; margin-left: 5px; font-size: 14px; }
    .btn-accept { background-color: #2BA18E; color: #fff; }
    .btn-refuse { background-color: #e74c3c; color: #fff; }
  </style>
</head>
<body>
<main>
  <div class="invitations-container">
    <h2>Invitations reçues</h2>
    <?php if (mysqli_num_rows($result_received) > 0): ?>
      <ul class="invitation-list">
        <?php while ($inv = mysqli_fetch_assoc($result_received)): ?>
          <li class="invitation-item">
            <div>
              <strong><?php echo $inv['prenom'] . ' ' . $inv['nom']; ?></strong>
              <small> - <?php echo date("d/m/Y H:i", strtotime($inv['date'])); ?></small>
            </div>
            <div class="actions">
              <form action="manage.php" method="POST">
                <input type="hidden" name="invitation_id" value="<?php echo $inv['id']; ?>">
                <input type="hidden" name="action" value="accept">
                <button type="submit" class="btn btn-accept"><i class="fas fa-check"></i> Accepter</button>
              </form>
              <form action="manage.php" method="POST">
                <input type="hidden" name="invitation_id" value="<?php echo $inv['id']; ?>">
                <input type="hidden" name="action" value="refuse">
                <button type="submit" class="btn btn-refuse"><i class="fas fa-times"></i> Refuser</button>
              </form>
            </div>
          </li>
        <?php endwhile; ?>
      </ul>
    <?php else: ?>
      <p>Aucune invitation reçue en attente.</p>
    <?php endif; ?>

    <h2>Historique des invitations envoyées</h2>
    <?php if (mysqli_num_rows($result_sent) > 0): ?>
      <ul class="history-list">
        <?php while ($sent = mysqli_fetch_assoc($result_sent)): ?>
          <li class="history-item">
            <div>
              <strong><?php echo $sent['prenom'] . ' ' . $sent['nom']; ?></strong>
              <small> - <?php echo date("d/m/Y H:i", strtotime($sent['date'])); ?></small>
            </div>
            <div>
              Statut: <em><?php echo ucfirst($sent['status']); ?></em>
            </div>
          </li>
        <?php endwhile; ?>
      </ul>
    <?php else: ?>
      <p>Aucune invitation envoyée.</p>
    <?php endif; ?>
  </div>


</main>
</body>
</html>
