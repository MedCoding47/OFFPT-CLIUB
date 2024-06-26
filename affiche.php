<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Club Information</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        button {
            padding: 5px 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        .add-club-button {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<h1>Club Information</h1>

<table id="club-table">
    <tr>
        <th>Name</th>
        <th>Responsible</th>
        <th>Event</th>
        <th>Action</th>
    </tr>
    <!-- Existing club rows will be dynamically added here -->
</table>

<!-- Button to add a new club -->
<button class="add-club-button" onclick="addClub()">Add Club</button>

<script>
    function addClub() {
        // Prompt user to enter club details
        var clubName = prompt("Enter club name:");
        var responsible = prompt("Enter responsible person:");
        var event = prompt("Enter event:");

        // Check if the user entered all required details
        if (clubName && responsible && event) {
            // Create a new row in the table
            var table = document.getElementById("club-table");
            var newRow = table.insertRow(-1); // Insert at the end of the table
            var cells = [];

            // Create cells for each column
            for (var i = 0; i < 4; i++) {
                cells.push(newRow.insertCell(i));
            }

            // Set cell values
            cells[0].innerText = clubName;
            cells[1].innerText = responsible;
            cells[2].innerText = event;
            cells[3].innerHTML = "<button>Add</button>";
        } else {
            // Show an alert if any required detail is missing
            alert("Please enter all required details.");
        }
    }
</script>

</body>
</html>
