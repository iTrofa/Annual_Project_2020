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
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>-->
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
$DbManager = new  DbManager();
$q = "SELECT * FROM person";
$req = $DbManager->getDb()->query($q);
$req->execute();

$results = [];
while ($user = $req->fetch()) {
    $results[] = $user;
}
$q = $DbManager->getDb()->prepare("SELECT * FROM service");
$q->execute();
$service = $q->fetchAll();
/*$serviceName = $service['name'][PDO::FETCH_ASSOC];
$serviceImage = $service['image'][PDO::FETCH_ASSOC];*/
?>
<div class="container">
    <h1 id="welcomeInput">Welcome to Flash Assistance <?= $_SESSION['firstName']?></h1><br><br>
</div>



<div class="bd-example">
    <div id="carouselExampleCaptions" style="width: 50%;margin-left: 25%;" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleCaptions" data-slide-to="1" class=""></li>
            <li data-target="#carouselExampleCaptions" data-slide-to="2" class=""></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block w-100" alt="Third slide [800x400]" src="images/childcare.jpg" data-holder-rendered="true">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Babysitting</h5>
                    <p>Amazing ChildCare</p>
                </div>
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" alt="Third slide [800x400]" src="images/lawnmower.jpg" data-holder-rendered="true">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Lawnmower</h5>
                    <p>Your lawn will be perfect !</p>
                </div>
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" alt="Third slide [800x400]" src="images/Raking-leaves.jpg" data-holder-rendered="true">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Raking Leaves</h5>
                    <p>Get this amazing service only for the price of a toilet paper.</p>
                </div>
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</div>
















<!--
<div id="carouselExampleIndicators" style="text-align: center" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img class="d-block" style="width: 30%"  src="images/childcare.jpg" alt="First slide">
            <div class="carousel-caption d-none d-md-block">
                <h5>Buy our Service</h5>
                <p>Only some money and Covid-19 LUL</p>
            </div>
        </div>
        <div class="carousel-item">
            <img class="d-block" style="width: 30%" src="images/Raking-leaves.jpg" alt="Second slide">
            <div class="carousel-caption d-none d-md-block">
                <h5>Buy our Service</h5>
                <p>Only some money and Covid-19 LUL</p>
            </div>
        </div>
        <div class="carousel-item">
            <img class="d-block"  style="width: 30%" src="images/lawnmower.jpg" alt="Third slide">
            <div class="carousel-caption d-none d-md-block">
                <h5>Buy our Service</h5>
                <p>Only some money and Covid-19 LUL</p>
            </div>
        </div>
    </div>
    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>-->



<!--<div class="container">
    <h2>Carousel Example</h2>
    <div id="myCarousel" class="carousel slide" data-ride="carousel">-->
        <!-- Indicators -->
       <!-- <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
            <li data-target="#myCarousel" data-slide-to="2"></li>
        </ol>-->

        <!-- Wrapper for slides -->
      <!--  <div class="carousel-inner">

            <div class="item active">
                <img src="images/Raking-leaves.jpg" alt="Los Angeles" style="width:40%;">
                <div class="carousel-caption">
                    <h3>Los Angeles</h3>
                    <p>LA is always so much fun!</p>
                </div>
            </div>

            <div class="item">
                <img src="images/lawnmower.jpg" alt="Chicago" style="width:40%;">
                <div class="carousel-caption">
                    <h3>Chicago</h3>
                    <p>Thank you, Chicago!</p>
                </div>
            </div>

            <div class="item">
                <img src="images/childcare.jpg" alt="New York" style="width:40%;">
                <div class="carousel-caption">
                    <h3>New York</h3>
                    <p>We love the Big Apple!</p>
                </div>
            </div>

        </div>-->

        <!-- Left and right controls -->
       <!-- <a class="left carousel-control" href="#myCarousel" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#myCarousel" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</div>-->

<!--<div class="container">
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
</div>-->
<br>
<br>
<br>


<?php
include("footer.php"); ?>
</body>
</html>

