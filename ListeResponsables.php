<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Responsable Inscription Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
</head>

<body>
<div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="welcome.php">Home</a>
                    </li>
                </ul>
            </div>
    <div class="container">
        <h1 class="mt-5"> Responsables</h1>
        <a href="AjoutResponsables.php" class="btn btn-danger" style="margin-bottom:20px;width:100%">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                class="bi bi-person-plus-fill" viewBox="0 0 16 16">
                <path
                    d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                <path fill-rule="evenodd"
                    d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z" />
            </svg>
        </a><br>

        <table id="example" class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Role</th>
                    <th>Date of Birth</th>
                    <th>Gender</th>
                    <th>Phone</th>
                    <th>pwd</th>
                    <th>Modifier</th>
                 
                </tr>
            </thead>
            <tbody>
                <?php
                include_once("connexion.php");
                $query = "SELECT Code, Nom, Email, Address, Role, DateOfBirth, Gender, Phone, pwd FROM Responsable";
                $pdostmt = $connexion->prepare($query);
                $pdostmt->execute();
                while ($ligne = $pdostmt->fetch(PDO::FETCH_ASSOC)):
                ?>
                <tr>
                    <td><?php echo $ligne["Code"]; ?></td>
                    <td><?php echo $ligne["Nom"]; ?></td>
                    <td><?php echo $ligne["Email"]; ?></td>
                    <td><?php echo $ligne["Address"]; ?></td>
                    <td><?php echo $ligne["Role"]; ?></td>
                    <td><?php echo $ligne["DateOfBirth"]; ?></td>
                    <td><?php echo $ligne["Gender"]; ?></td>
                    <td><?php echo $ligne["Phone"]; ?></td>
                    <td><?php echo $ligne["pwd"]; ?></td>
                    <td>
                        <a href="Modifrespo.php?id=<?php echo $ligne["Code"] ?>" class="btn btn-success">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-pencil" viewBox="0 0 16 16">
                                <path
                                    d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                            </svg>
                        </a>
                    </td>
                   
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>

</html>
