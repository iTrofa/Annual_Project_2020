<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<html lang="fr">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="images/logo_dark.png"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
            integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
            integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
            crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
            integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/main.css">
    <title>Flash Assistance</title>
    <script src="header.js"></script>
    <script src="footer.js"></script>
</head>
<body onload="checkFooter()">
<?php

require('DbManager.php');
include('header.php');
?>

<br><br><br><br>
<?php
//List of Workers
$q = "SELECT * FROM person";
$req = $db->prepare($q);
$req->execute();


$results = [];
while ($user = $req->fetch()) {
    $results[] = $user;
}
?>
<div class="container">
    <h1 id="welcomeInput">Welcome to Flash Assistance <?= $_SESSION['firstName']?></h1><br><br>
    <h2 style="padding-top: 25%">List of all Users:</h2>
    <input class='form-control mb-4' id='tableSearch' type='text' placeholder='Type something to search list items'>
    <table class="table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Firstname</th>
            <th>Lastname</th>
            <th>Email</th>
            <th>Phone Number</th>
            <th>Function</th>
            <th>Localisation</th>
        </tr>
        </thead>
        <tbody id="myTable">
        <?php

        for ($i = 0; $i < sizeof($results); $i++) {
            $firstName = $results[$i]['firstName'];
            $lastName = $results[$i]['lastName'];
            $email = $results[$i]['email'];
            $phone = $results[$i]['phoneNumber'];
            $idPerson = $results[$i]['idPerson'];
            $function = $results[$i]['function'];
            $localisation = $results[$i]['localisation'];
            /* $q = $bdd->prepare("SELECT idPerson FROM worker where idPerson = :idPerson");
             $q->bindParam(':idPerson', $idPerson);
             $q->execute();
             $worker = $q->fetchall();
             $worker = $worker[0]['idPerson'];
             if($worker == ""){
                 $worker = "Not a worker";
             }else{
                 $worker = "Worker";
             }*/
            echo "<tr>";
            echo "<td>" . $idPerson . "</td>";
            echo "<td>" . $firstName . "</td>";
            echo "<td>" . $lastName . "</td>";
            echo "<td>" . $email . "</td>";
            echo "<td>" . $phone . "</td>";
            echo "<td>" . $function . "</td>";
            echo "<td>" . $localisation . "</td>";
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>
</div>
<br>
<br>
<br>


<?php
include("footer.php"); ?>
</body>
</html>

