<?php
include_once("connexion.php");

$query = "SELECT a.code, c.libelle AS ClubName, a.jourP, a.DateR, a.Description, a.Observation, a.picture_path, a.type
          FROM Activities a
          INNER JOIN Club c ON a.CodeClub = c.CodeClub";
$pdostmt = $connexion->prepare($query);
$pdostmt->execute();
$activities = $pdostmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Club Activities</title>
    <link rel="stylesheet" href="test.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f8f8;
            height:1000px;
        }

        .section {
            margin: 40px auto;
            padding: 0 20px;
            max-width: 1200px;
        }
        .section-title {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }
        .activities-container {
            display: flex;
            flex-wrap: wrap;
        }
        .activity {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: 10px;
            padding: 15px;
            flex: 1 1 calc(33.333% - 20px);
            box-sizing: border-box;
            display: flex;
            flex-direction: row;
            height: 280px;
        }
        .activity img {
    max-width: 200px; /* Adjust the maximum width as needed */
    margin-right: 15px;
    border-radius: 5px;
    height: auto;
    width: 100%; /* This ensures the image scales proportionally */
}

        .activity h3 {
            font-size: 1.5rem;
            color: #333;
            margin-top: 0;
        }
        .activity p {
            font-size: 1.3rem;
            color: #666;
            margin-bottom: 10px;
        }
        .activity-date {
            font-size: 0.9rem;
            color: #999;
        }
    </style>
</head>
<body>
<header>
    <div class="logo">
        <p><span>Activities</span> Page</p>
    </div>
    <ul class="menu">
        <li><a href="acceuil.php">Home</a></li>
        <li><a href="activities.php">Menu</a></li>
        <li><a href="profiladhrent.php">Members</a></li>
        <li><a href="welcome.php">Admin</a></li>
    </ul>
</header>
<br><br><br>
<div id="social-activities" class="section">
    <div class="section-title">Social Activities</div>
    <div class="activities-container">
        <!-- Social Activities will be loaded here -->
    </div>
</div>



<div id="donate-volunteer" class="section">
    <div class="section-title">Donate & Volunteer</div>
    <div class="activities-container">
        <!-- Donate & Volunteer will be loaded here -->
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        fetch('get_activities.php')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    displayActivities(data.activities);
                }
            });
    });

    function displayActivities(activities) {
        const socialContainer = document.querySelector('#social-activities .activities-container');
        const exclusiveContainer = document.querySelector('#exclusive-events .activities-container');
        const donateContainer = document.querySelector('#donate-volunteer .activities-container');

        activities.forEach(activity => {
            const activityElement = createActivityElement(activity);
            if (activity.type === 'Social Activities') {
                socialContainer.appendChild(activityElement);
            } else if (activity.type === 'Exclusive Events') {
                exclusiveContainer.appendChild(activityElement);
            } else if (activity.type === 'Donate & Volunteer') {
                donateContainer.appendChild(activityElement);
            }
        });
    }

    function createActivityElement(activity) {
        const activityElement = document.createElement('div');
        activityElement.classList.add('activity');

        const imageElement = document.createElement('img');
        imageElement.src = activity.image_url || 'images/default_event_image.png';
        activityElement.appendChild(imageElement);

        const detailsElement = document.createElement('div');
        detailsElement.classList.add('details');

        const titleElement = document.createElement('h3');
        titleElement.textContent = activity.title;
        detailsElement.appendChild(titleElement);

        const descriptionElement = document.createElement('p');
        descriptionElement.textContent = activity.description;
        detailsElement.appendChild(descriptionElement);

        const dateElement = document.createElement('p');
        dateElement.textContent = new Date(activity.date).toLocaleDateString();
        dateElement.classList.add('activity-date');
        detailsElement.appendChild(dateElement);

        activityElement.appendChild(detailsElement);

        return activityElement;
    }
</script>
</body>
</html>
