<?php

if (!isset($_SESSION['user_id'])) {
  echo "Vous devez être connecté.";
  exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Messenger</title>
  <link rel="stylesheet" href="style.css">
  <style>
    .chat-circle {
      position: fixed;
      bottom: 20px;
      right: 20px;
      background-color: #007bff;
      color: white;
      border-radius: 50%;
      width: 60px;
      height: 60px;
      font-size: 24px;
      display: flex;
      justify-content: center;
      align-items: center;
      cursor: pointer;
      z-index: 999;
    }

    .chat-box {
      position: fixed;
      bottom: 90px;
      right: 20px;
      width: 350px;
      max-height: 500px;
      background: #fff;
      border: 1px solid #ccc;
      border-radius: 12px;
      display: none;
      flex-direction: column;
      z-index: 999;
    }

    .chat-header {
      background: #007bff;
      color: white;
      padding: 10px;
      font-weight: bold;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .chat-body {
      flex: 1;
      padding: 10px;
      overflow-y: auto;
    }

    .chat-input {
      display: flex;
      padding: 10px;
      border-top: 1px solid #ccc;
    }

    .chat-input input {
      flex: 1;
      padding: 8px;
    }

    .chat-input button {
      padding: 8px;
    }

    .message {
      margin-bottom: 10px;
      padding: 8px;
      border-radius: 10px;
    }

    .sent { background-color: #dcf8c6; align-self: flex-end; }
    .received { background-color: #f1f0f0; align-self: flex-start; }
  </style>
</head>
<body>

<!-- Cercle Messenger -->
<div class="chat-circle" id="chatToggle">
  💬
</div>

<!-- Fenêtre Messenger -->
<div class="chat-box" id="chatBox">
  <div class="chat-header">
    Messenger
    <button onclick="closeChat()">X</button>
  </div>
  <div style="padding: 10px;">
    <select id="friendSelect" onchange="loadMessages()">
      <option value="">Choisir un ami</option>
    </select>
  </div>
  <div class="chat-body" id="chatMessages"></div>
  <div class="chat-input">
    <input type="text" id="messageInput" placeholder="Écrire un message...">
    <button onclick="sendMessage()">Envoyer</button>
  </div>
</div>

<script>
  let currentFriendId = null;

  // Affiche/masque le chat
  document.getElementById('chatToggle').addEventListener('click', () => {
    const box = document.getElementById('chatBox');
    box.style.display = box.style.display === 'flex' ? 'none' : 'flex';
    loadFriends();
  });

  function closeChat() {
    document.getElementById('chatBox').style.display = 'none';
  }

  function loadFriends() {
    fetch('get_friends.php')
      .then(res => res.json())
      .then(data => {
        const select = document.getElementById('friendSelect');
        select.innerHTML = '<option value="">Choisir un ami</option>';
        data.forEach(friend => {
          const opt = document.createElement('option');
          opt.value = friend.id;
          opt.textContent = friend.prenom + ' ' + friend.nom;
          select.appendChild(opt);
        });
      });
  }

  function loadMessages() {
    currentFriendId = document.getElementById('friendSelect').value;
    if (!currentFriendId) return;

    fetch(`load_messages.php?receiver_id=${currentFriendId}`)
      .then(res => res.json())
      .then(data => {
        const container = document.getElementById('chatMessages');
        container.innerHTML = '';
        data.forEach(msg => {
          const div = document.createElement('div');
          div.classList.add('message');
          div.classList.add(msg.sender_id == <?= $_SESSION['user_id'] ?> ? 'sent' : 'received');
          div.textContent = msg.text;
          container.appendChild(div);
        });
        container.scrollTop = container.scrollHeight;
      });
  }

  function sendMessage() {
    const input = document.getElementById('messageInput');
    const text = input.value.trim();
    if (!text || !currentFriendId) return;

    fetch('send_message.php', {
      method: 'POST',
      headers: {'Content-Type': 'application/json'},
      body: JSON.stringify({
        receiver_id: currentFriendId,
        text: text
      })
    }).then(() => {
      input.value = '';
      loadMessages();
    });
  }
</script>

</body>
</html>
