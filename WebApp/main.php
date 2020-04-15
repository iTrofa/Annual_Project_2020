<?php
require_once "session.php";
?>
<html>
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

require_once "localization.php";
include('header.php');
?>

<br><br><br><br>
<?php
//List of Workers
$DbManager = App::getDb();
$q = 'SELECT * FROM person';
$req = $DbManager->query($q);


$results = [];
while ($user = $req->fetch()) {
    $results[] = $user;
}
$q = $DbManager->query('SELECT * FROM service');

$service = $q->fetchAll();
?>
    <h1 id="welcomeInput"><?= _("Welcome to Flash Assistance") . " " . $_SESSION['firstName']?></h1><br><br>
<?php
$firstImage = $service[0]['image'];
$firstDesc = $service[0]['description'];
$firstSerName = $service[0]['name'];
?>

<a href="services.php">
<div class="bd-example">
    <div id="carouselExampleCaptions" style="width: 50%;margin-left: 25%;" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <?php
            echo "<li data-target=\"#carouselExampleCaptions\" data-slide-to=\"0\" class=\"active\"></li>";
            for($i=1, $iMax = count($service); $i< $iMax; $i++){
            echo "<li data-target=\"#carouselExampleCaptions\" data-slide-to=\".$i.\" class=\"\"></li>";
            }
            ?>
        </ol>
        <?php
        echo "<div class=\"carousel-inner\">";
            echo "<div class=\"carousel-item active\">";
                echo "<img class='d-block w-100' alt='' src='$firstImage' data-holder-rendered='true'>";
                echo "<div class=\"carousel-caption d-none d-md-block carousel-color\">";
                    echo "<h5 class=\"carousel-label-color\">$firstSerName</h5>";
                    echo "<p class=\"carousel-label-color\">$firstDesc</p>";
                echo "</div>";
            echo "</div>";
            for ($i = 1, $iMax = count($service); $i< $iMax; $i++){
                $image = $service[$i]['image'];
                $desc = $service[$i]['description'];
                $SerName = $service[$i]['name'];

            echo "<div class=\"carousel-item\">";
                echo "<img class=\"d-block w-100\" alt=\"\" src=\"$image\" data-holder-rendered=\"true\">";
                echo "<div class=\"carousel-caption d-none d-md-block carousel-color\">";
                    echo "<h5 class=\"carousel-label-color\">$SerName</h5>";
                    echo "<p class=\"carousel-label-color\">$desc</p>";
                echo "</div>";
            echo "</div>";
            }
            ?>
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
</a>

<br><br>
<div class="row" style="margin: 0; margin-top: 7.5%">
    <div class="col-sm-5" style="margin-left: 20%">
      <img src="images/childcare.jpg" style="width: 59%;display: inline-block;">
    </div>
    <div class="col-sm-3">
        <h5 style="margin-top: 15%"><?= _('Enjoy all your favorite services for to half the price')?></h5>
        <a href="subscription.php"><input type="button" value="Get your Subscription" class="btn-primary btn-large btn"/></a>
    </div>
</div>
<br><br><br>


<?php
include("footer.php"); ?>
</body>
</html>
