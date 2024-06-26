<?php
session_start();
include_once("connexion.php");

if (!isset($_SESSION['CodeEleve'])) {
    header("Location: login.php");
    exit();
}

$codeEleve = $_SESSION['CodeEleve'];
$query = "
    SELECT Responsable.Nom AS ResponsableNom, Club.Libelle AS ClubLibelle
    FROM Responsable
    LEFT JOIN Club ON Responsable.Code = Club.CodeResp
    WHERE Responsable.Code = :CodeEleve
";
$pdostmt = $connexion->prepare($query);
$pdostmt->execute(["CodeEleve" => $codeEleve]);

$result = $pdostmt->fetch();
$pdostmt->closeCursor();

$responsableNom = $result['ResponsableNom'];
$clubLibelle = $result['ClubLibelle'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Welcome Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="test.css">
    <style>
        .welcome-container {
            margin-top: 100px;
            text-align: center;
        }
        .welcome-container h2 {
            font-size: 2.5em;
            margin-bottom: 100px;
        }
        .welcome-container p {
            font-size: 1.5em;
        }
        #messaging {
            margin: 20px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            background-color: #f9f9f9;
        }
        .messages-container {
            height: 300px;
            overflow-y: auto;
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
            background-color: #fff;
        }
        .message {
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 5px;
        }
        .self-message {
            background-color: red;
            color: white;
            align-self: flex-start;
        }
        .other-message {
            background-color: blue;
            color: white;
            align-self: flex-end;
        }
        #message-form {
            display: flex;
            align-items: center;
        }
        #message-input {
            flex-grow: 1;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-right: 10px;
        }
        #message-form button {
            padding: 10px 20px;
            background-color: #0288d1;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        #message-form button:hover {
            background-color: #0277bd;
        }
    </style>
</head>
<body>

<header>
    <div class="logo">
        <p><span>Admin</span>page</p>
    </div>
    <ul class="menu">
        <li><a href="acceuil.php">Acceuil</a></li>
        <li><a href="ListeResponsables.php">Responsable</a></li>
        <li><a href="liste_adherents.php">members</a></li>


        <li><a href="list_activities.php">activites</a></li>
        <li><a href="liste_evenements.php">events</a></li>
        <li><a href="LISTEPARTICIPANT.PHP">participant</a></li>
        <li><a href="clubs.php">clubs</a></li>
        <li><a href="logout2.php" >Logout</a></li>
        <li><button id="message-toggle-button" class="btn btn-secondary"><i  class="fas fa-envelope"></i></button></li>
    </ul>
    <div class="toggle_menu"></div>
</header>

<div class="container welcome-container">
    <h2>Welcome</h2>
    <p>Responsable Name: <?php echo htmlspecialchars($responsableNom); ?></p>
</div>

<!-- Messaging Section -->
<section id="messaging" style="display: none;">
    <h2>Messagerie</h2>
    <div class="messages-container" id="messages-container"></div>
    <form id="message-form">
        <textarea id="message-input" placeholder="Type your message here..."></textarea>
        <button type="submit">Send</button>
    </form>
</section>

<script>
document.getElementById('message-form').addEventListener('submit', function(event) {
    event.preventDefault();
    const message = document.getElementById('message-input').value;
    if (message.trim()) {
        fetch('send_message.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ message: message }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                loadMessages();
                document.getElementById('message-input').value = '';
            }
        });
    }
});

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('message-toggle-button').addEventListener('click', function() {
        const messagingSection = document.getElementById('messaging');
        messagingSection.style.display = messagingSection.style.display === 'none' ? 'block' : 'none';
    });

    loadMessages();
});

function loadMessages() {
    fetch('get_messages.php')
        .then(response => response.json())
        .then(data => {
            const messagesContainer = document.getElementById('messages-container');
            messagesContainer.innerHTML = '';
            data.messages.forEach(message => {
                const messageElement = document.createElement('div');
                messageElement.classList.add('message');
                
                // Apply style for other messages
                messageElement.classList.add('other-message');
                
                // Display sender's name and message content
                messageElement.textContent = message.sender_name + ': ' + message.message;
                messagesContainer.appendChild(messageElement);
            });
        });
}

loadMessages();

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3BF0XUYXK4A/vyyaX/ZdA6+Wj/qnY1dFVmsMSzQJpfIdYyIIjycW9ApyH3iKnQJ" crossorigin="anonymous"></script>
</body>
</html>

