<?php
require('DbManager.php');
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<head>
    <title>Services - Flash Assistance</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=Playfair+Display&display=swap' rel='stylesheet'>
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
    <link rel='stylesheet' href='css/services.css'>
    <link rel="icon" href="images/logo_dark.png">
    <script src="header.js"></script>
    <script src="footer.js"></script>
    <script>
        $(document).ready(function () {
            $("#serviceSearch").on("keyup", function () {
                var value = $(this).val().toLowerCase();
                $(".row .col").filter(function () {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>
</head>
<?php
include('header.php'); ?>
<body onload='checkFooter()'>
<br><br><br><br>
<?php

//List of Workers
$DbManager = new DbManager();
$q = "SELECT * FROM service";
$req = $DbManager->getDb()->query($q);
$req->execute();
$results = [];
while ($user = $req->fetch()) {
    $results[] = $user;
}
if (!empty($_GET['services'])) {
    echo "<div class='container'>";
    $q = $DbManager->getDb()->prepare("SELECT * FROM service where idService =:id");
    $q->bindParam(':id', $_GET['services']);
    $q->execute();

    $results = [];
    while ($user = $q->fetch()) {
        $results[] = $user;

    }
    $chosenService = $results[0]['name'];
    $chosenServiceDemo = $results[0]['demo'];
    $chosenServiceId = $results[0]['idService'];
    $chosenServicePrice = $results[0]['price'];
    $image = $results[0]['image'];
    $chosenServicefinal = strtolower($chosenService);
    $chosenServicefinal = str_replace(' ', '', $chosenServicefinal);
    ?>
    <h2 class="fontPlaynoDisplay">Personalise your Service !</h2>
    <!--    <div class="image" style="background-image: url('<?php /*echo $image */
    ?>'); background-repeat: no-repeat; width: 100%; height: 100%;"></div>
-->
    <img src='<?= $image ?>' alt='<?= $chosenServicefinal ?>' style='width:40%;'>
    <p class='fontPlay'><?= $chosenService ?>&nbsp;</p>
    <!--<p> <?= $chosenServiceDemo ?></p>
           <p><?= $chosenServiceId ?></p>"; -->

    <p class='fontPlay'><?= $chosenServicePrice ?>€/day </p>
    <br><br>
    <p class='fontPlaySmall'>Get for every 12 interventions 2 free. Only <?= $chosenServicePrice * 10 ?>€ </p>
    <br>
    <div class="container container2">
        <h1>Reservations</h1>
        <br>
        <h3>Choose your Package</h3>
        <form action='payment.php' method="post" onchange='updatePrice()' id='reservation'>
            <input type="number" max='8' min='1' class='inputSmaller' name='reservationInput' id='reservationInput'
                   placeholder='Number of..'>
            <select name='userOption' onchange="myFunction()" id='userOption'>
                <option>-----</option>
                <option>Hour(s)</option>
                <option>Day(s)</option>
                <option>Month(s)</option>
                <option>Year(s)</option>
            </select>
            <br>
            <input name='noinput' min='1' max='8' type='hidden' id='noinput' placeholder='' class='input'>
            <br>
            <button type="submit" class="btn btn-primary btn-block2 btn-large">Confirm</button>
        </form>
        <div class="card" style="width: 18rem;padding-left: 0px;left: 75%;top: 100%;position: absolute">
            <div class="card-header">
                Price
            </div>
            <ul class="list-group list-group-flush">
                <li class='list-group-item'> <?= $chosenService ?></li>
                <li id="updatePrice" value="<?= $chosenServicePrice ?>" class="list-group-item"></li>
            </ul>
        </div>
    </div>
    <?php
} else {
    ?>
    <div class="container">
        <h2>List of all the Services we currently provide :</h2>
        <br>
        <input class='form-control mb-4' id='serviceSearch' type='text'
               placeholder='Type something to search list items'>
        <br>
        <div class="row">
            <?php
            for ($i = 0, $iMax = count($results); $i < $iMax; $i++):
                $service = $results[$i]['name'];
                $servicedemo = $results[$i]['demo'];
                $serviceid = $results[$i]['idService'];
                $image = $results[$i]['image'];
                $servicefinal = strtolower($service);
                $servicefinal = trim($servicefinal);
                $servicefinal = str_replace(' ', '', $servicefinal); ?>
                <div class='col-md-4 col'>
                    <div class='thumbnail'>
                        <a href="services.php?services=<?=$serviceid?>">
                            <img src="<?= $image ?>" alt="<?=$servicefinal ?>" style="width:100%">
                            <div class="caption">
                                <p><?= $service ?></p>
                            </div>
                        </a>
                    </div>
                </div>
            <?php
            endfor;
            ?>
        </div>
    </div>
    <?php
}
?>
<br>
<br>
<br>


</body>
<?php

include 'footer.php';
?>

