<?php
require('config.php');
?>
<head>
<title>Services - Flash Assistance</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<link href='https://fonts.googleapis.com/css?family=Playfair+Display&display=swap' rel='stylesheet'>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<link rel="stylesheet" href="css/main.css">
<link rel='stylesheet' href='css/services.css'>
<link rel="icon" href="images/logo_dark.png">
<script src="header.js"></script>
<script src="footer.js"></script>
<script>
    $(document).ready(function(){
        $("#serviceSearch").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $(".row .col").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>
</head>
<?php
include('header.php');
echo "<body onload='checkFooter()'>";
echo "<br><br><br><br>";
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
 //List of Workers
$q = "SELECT * FROM service";
$req = $db->prepare($q);
$req->execute();

$results = [];
while($user = $req->fetch()) {
    $results[] = $user;
}
if(isset($_GET['services'])){
    echo "<div class='container'>";
    $q = $db->prepare("SELECT * FROM service where idService =:id");
    $q->bindParam(':id', $_GET['services']);
    $q->execute();

    $results = [];
    while($user = $q->fetch()) {
        $results[] = $user;

    }
    $chosenService = $results[0]['name'];
    $chosenServiceDemo = $results[0]['demo'];
    $chosenServiceId = $results[0]['idService'];
    $chosenServicePrice = $results[0]['price'];
    $chosenServiceImage = $results[0]['image'];
    $chosenServicefinal = strtolower($chosenService);
    $chosenServicefinal = str_replace(" ", "", $chosenServicefinal);
    $image = "images/".$chosenServiceImage;
    ?>
    <h2 class="fontPlaynoDisplay">Personalise your Service !</h2>
<!--    <div class="image" style="background-image: url('<?php /*echo $image */?>'); background-repeat: no-repeat; width: 100%; height: 100%;"></div>
-->   <?php
    echo "<img src='$image' alt='$chosenServicefinal' style='width:40%;'> ";
    echo "<p class='fontPlay'>" . $chosenService . "&nbsp;</p>";
    /*echo "<p>" . $chosenServiceDemo . "</p>";
    echo "<p>" . $chosenServiceId . "</p>";*/

    echo "<p class='fontPlay'>" . $chosenServicePrice . "€/day. </p>";
    echo "<br><br>";
    echo "<p class='fontPlaySmall'>Get for every 12 interventions 2 free. Only " . $chosenServicePrice*10 . "€ </p>";
    echo "<br>";
      echo "<div class=\"container container2\">";
      echo "<h1>Reservations</h1>";
      echo "<br>";
      echo "<h3>Choose your Package</h3>";
    echo "<form action='payment.php' method=\"post\" onchange='updatePrice()' id='reservation'>";
        echo "<input type=\"number\" max='8' min='1' class='inputSmaller' name='reservationInput' id = 'reservationInput' placeholder='Number of..'>";
    echo "<select name='userOption' onchange=\"myFunction()\"id='userOption'>";
    echo "<option>-----</option>";
    echo "<option>Hour(s)</option>";
    echo "<option>Day(s)</option>";
    echo "<option>Month(s)</option>";
    echo "<option>Year(s)</option>";
    echo "</select>";
        echo "<br>";
        echo "<input name='noinput' min='1' max='8' type='hidden' id='noinput' placeholder='' class='input'>";
        echo "<br>";
        echo "<button type=\"submit\" class=\"btn1 btn1-primary btn-block2 btn-large\">Confirm</button>";
    echo "</form>";
    ?>
    <div class="card" style="width: 18rem;padding-left: 0px;left: 75%;top: 100%;position: absolute">
        <div class="card-header">
            Price
        </div>
        <ul class="list-group list-group-flush">
            <?= "<li class='list-group-item'>". $chosenService . "</li>"?>
            <?= "<li id='updatePrice' value=$chosenServicePrice class='list-group-item'></li>"?>
        </ul>
    </div>
    </div>
    </div>
    <?php
}else{?>
<div class="container">
    <h2>List of all the Services we currently provide :</h2>
    <br>
    <input class='form-control mb-4' id='serviceSearch' type='text' placeholder='Type something to search list items'>
    <br>
    <div class="row">
        <?php
        for($i=0; $i<sizeof($results);$i++){
            $service = $results[$i]['name'];
            $servicedemo = $results[$i]['demo'];
            $serviceid = $results[$i]['idService'];
            $serviceImage = $results[$i]['image'];
            $servicefinal = strtolower($service);
            $servicefinal = trim($servicefinal);
            $servicefinal = str_replace(' ', '', $servicefinal);
            echo "<div class='col-md-4 col'>";
                echo "<div class='thumbnail'>";
                    echo "<a href='services.php?services=$serviceid'>";
                    $image = "images/".$serviceImage;
                         echo "<img src='$image' alt='$servicefinal' style='width:100%'>";
                        echo "<div class='caption'>";
                            echo "<p>" . $service. "</p>";
                        echo "</div>";
                    echo "</a>";
                echo "</div>";
            echo "</div>";
        }
        ?>
        </div>
    </div>
<?php
}
?>
<br>
<br>
<br>



<?php
 echo "</body>";
include ("footer.php");



