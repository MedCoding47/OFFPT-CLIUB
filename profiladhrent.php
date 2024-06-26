<?php
session_start();
include_once("connexion.php");

if (!isset($_SESSION['CodeAdhrents'])) {
    header("Location: loginadhrent.php");
    exit();
}

$user_id = $_SESSION['CodeAdhrents'];
$sql = "
    SELECT a.*, c.Libelle AS ClubName
    FROM Adherents a
    LEFT JOIN Club c ON a.CodeClub = c.CodeClub
    WHERE a.CodeAdhrents = :user_id
";
$stmt = $connexion->prepare($sql);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();

$user = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$user) {
    header("Location: logout.php");
    exit();
}

$sql_events = "
    SELECT e.Code AS EventID, e.nom_event
    FROM Evenements e
    INNER JOIN EventParticipants p ON e.Code = p.event_id
    WHERE p.CodeAdhrents = :user_id
";
$stmt_events = $connexion->prepare($sql_events);
$stmt_events->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt_events->execute();

$events = $stmt_events->fetchAll(PDO::FETCH_ASSOC);

$success_message = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : '';
$error_message = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : '';
unset($_SESSION['success_message'], $_SESSION['error_message']);

$uploads_dir = "uploads/";
$default_picture = "default.png";
$picture_path = $uploads_dir . (!empty($user['picture']) ? $user['picture'] : $default_picture);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil de l'Adhérent</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="test.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        .profile-container {
            width: 50%;
            margin: auto;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 8px;
            background-color: #f9f9f9;
            margin-top: 20px;
        }
        .profile-container h2 {
            text-align: center;
        }
        .profile-container table {
            width: 100%;
            border-collapse: collapse;
        }
        .profile-container th, .profile-container td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        .profile-container th {
            background-color: #f2f2f2;
        }
        .profile-container .btn-container {
            text-align: center;
            margin-top: 20px;
        }
        .profile-picture {
            display: block;
            margin-left: auto;
            margin-right: auto;
            border-radius: 50%;
            width: 150px;
            height: 150px;
            object-fit: cover;
        }
        .alert-success, .alert-danger {
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
        }
        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }
        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
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
            background-color: #e1f5fe;
            border-radius: 5px;
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
        .show-password-btn {
            margin-left: 10px;
            cursor: pointer;
            color: #007bff;
        }
        .show-password-btn:hover {
            text-decoration: underline;
        }
        .message {
            padding: 10px;
            margin: 5px 0;
            border-radius: 5px;
            max-width: 60%;
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
        .photo-gallery img {
            width: 150px;
            height: auto;
            margin: 5px;
        }
    </style>
</head>
<body>
<header>
    <div class="logo">
        <p><span>Profil</span>page</p>
    </div>
    <ul class="menu">
        <li><a href="edit_profile.php">Modifier</a></li>
        <li><a href="acceuil.php">Retour à l'Accueil</a></li>
        <li><a href="events.php">Club</a></li>
        <li><a href="delete_account.php">Supprimer mon compte</a></li>
        <li><a href="logout.php">Logout</a></li>
        <li><button id="message-toggle-button" class="btn btn-secondary"><i class="fas fa-envelope"></i></button></li>
    </ul>
    <div class="toggle_menu"></div>
</header>
<br>
<br>
<br>
<br>
<br>
<br>
<div class="profile-container">
    <h2>Profil de l'Adhérent</h2>
    <br>
    <?php if ($success_message): ?>
        <div class="alert alert-success">
            <?php echo htmlspecialchars($success_message); ?>
        </div>
    <?php endif; ?>
    <?php if ($error_message): ?>
        <div class="alert alert-danger">
            <?php echo htmlspecialchars($error_message); ?>
        </div>
    <?php endif; ?>
    <img src="<?php echo htmlspecialchars($picture_path); ?>" alt="Profile Picture" class="profile-picture">
    <br>
    <br>
    <br>
    <table class="table">
        <tr>
            <th>Nom</th>
            <td><?php echo htmlspecialchars($user['Nom']); ?></td>
        </tr>
        <tr>
            <th>Prénom</th>
            <td><?php echo htmlspecialchars($user['prenom']); ?></td>
        </tr>
        <tr>
            <th>Téléphone</th>
            <td><?php echo htmlspecialchars($user['telephone']); ?></td>
        </tr>
        <tr>
            <th>Email</th>
            <td><?php echo htmlspecialchars($user['email']); ?></td>
        </tr>
        <tr>
            <th>Filière</th>
            <td><?php echo htmlspecialchars($user['fielere']); ?></td>
        </tr>
        <tr>
            <th>Validation</th>
            <td><?php echo $user['valide'] ? 'Oui' : 'Non'; ?></td>
        </tr>
        <tr>
            <th>Club</th>
            <td><?php echo htmlspecialchars($user['ClubName']); ?></td>
        </tr>
        <tr>
            <th>Mot de passe</th>
            <td>
                <span id="password" style="display: none;"><?php echo htmlspecialchars($user['pwd']); ?></span>
                <span id="password-mask">**********</span>
                <a href="#" id="toggle-password" class="show-password-btn">Montrer</a>
            </td>
        </tr>
        <?php if (!empty($events)): ?>
            <tr>
                <th>Événements</th>
                <td>
                    <ul>
                        <?php foreach ($events as $event): ?>
                            <li><?php echo htmlspecialchars($event['nom_event']); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </td>
            </tr>
        <?php endif; ?>
    </table>
    <br>
   
<br>
<br>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.getElementById('toggle-password').addEventListener('click', function(event) {
    event.preventDefault();
    const password = document.getElementById('password');
    const passwordMask = document.getElementById('password-mask');
    if (password.style.display === 'none') {
        password.style.display = 'inline';
        passwordMask.style.display = 'none';
        this.textContent = 'Cacher';
    } else {
        password.style.display = 'none';
        passwordMask.style.display = 'inline';
        this.textContent = 'Montrer';
    }
});
</script>
</body>
</html>
