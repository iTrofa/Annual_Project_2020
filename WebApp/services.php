<?php
require_once "session.php";
require_once "localization.php";
?>
<head>
    <title><?= _("Services - Flash Assistance")?></title>
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
<body onload='checkFooter()'>
<?php
include('header.php'); ?>
<?php
if(isset($_GET['AddtoCart']) && $_GET['AddtoCart'] == "success"){
    echo "<h3 style='color: red;margin-left: 5%'>Successfully Added to cart</h3>";
}
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
    ?>
    <div class='container'>
    <?php
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
    <br><br><br><br>
    <h2 class="fontPlaynoDisplay"><?= _("Personalise your Service !")?></h2>
    <!--    <div class="image" style="background-image: url('<?php /*echo $image */
    ?>'); background-repeat: no-repeat; width: 100%; height: 100%;"></div>
-->
    <img src='<?= $image ?>' alt='<?= $chosenServicefinal ?>' style='width:40%;'>
    <p class='fontPlay'><?= $chosenService ?>&nbsp;</p>
    <!--<p> <?= $chosenServiceDemo ?></p>
           <p><?= $chosenServiceId ?></p>"; -->

    <p class='fontPlay'><?= $chosenServicePrice ?>€/<?=_("day")?> </p>
    <br><br>
    <p class='fontPlaySmall'><?= _("Get for every 12 interventions 2 free. Only") . " " . $chosenServicePrice * 10 ?>€ </p>
    <br>
    </div>
    <div class="container container2">
        <h1><?= _("Reservations")?></h1>
        <br>
        <h3><?= _("Choose your Package")?></h3>

        <form action='payment.php?services=<?=$_GET['services']?>' method="post" onchange='updatePrice()' id='reservation'>
            <input type="number" max='8' min='1' class='inputSmaller' name='reservationInput' id='reservationInput'
                   placeholder='<?= _("Number of..")?>'>
            <select name='userOption' onchange="myFunction()" id='userOption'>
                <option><?= _("Hour(s)")?></option>
                <option><?= _("Day(s)")?></option>
                <option><?= _("Month(s)")?></option>
                <option><?= _("Year(s)")?></option>
            </select>
            <br>
            <input onchange="updatePrice()" name='noinput' min='1' max='8' type='hidden' id='noinput' placeholder='' class='input'>
            <br>
            <div onchange="retrieveHour()" id="hourForm" style="text-align: initial; margin-left: 20%;display: block">
                <input class="inputSmaller" id="hourInput" type="date" name="hourInput"><br><br>
            </div>
            <div id="dayForm" style="text-align: left; margin-left: 20%;display: none">
                <input class='inputSmaller' onchange="updatePrice()" name='Monday' style='width: 1.5%' type='checkbox'><p class= 'font-italic mb-4' style='display: inline-block'> &nbsp&nbsp<?=_("Each Monday")?></p><br>
                <input class='inputSmaller' onchange="updatePrice()" name='Tuesday' style='width: 1.5%' type='checkbox'><p class= 'font-italic mb-4' style='display: inline-block'> &nbsp&nbsp<?=_("Each Tuesday")?></p><br>
                <input class='inputSmaller' onchange="updatePrice()" name='Wednesday' style='width: 1.5%' type='checkbox'><p class= 'font-italic mb-4' style='display: inline-block'> &nbsp&nbsp<?=_("Each Wednesday")?></p><br>
                <input class='inputSmaller' onchange="updatePrice()" name='Thursday' style='width: 1.5%' type='checkbox'><p class= 'font-italic mb-4' style='display: inline-block'> &nbsp&nbsp<?=_("Each Thursday")?></p><br>
                <input class='inputSmaller' onchange="updatePrice()" name='Friday' style='width: 1.5%' type='checkbox'><p class= 'font-italic mb-4' style='display: inline-block'> &nbsp&nbsp<?=_("Each Friday")?></p><br>
                <input class='inputSmaller' onchange="updatePrice()" name='Saturday' style='width: 1.5%' type='checkbox'><p class= 'font-italic mb-4' style='display: inline-block'> &nbsp&nbsp<?=_("Each Saturday")?></p><br>
                <input class='inputSmaller' onchange="updatePrice()" name='Sunday' style='width: 1.5%' type='checkbox'><p class= 'font-italic mb-4' style='display: inline-block'> &nbsp&nbsp<?=_("Each Sunday")?></p><br>
            </div>
            <div id="monthForm" style="text-align: left; margin-left: 20%;display: none">
                <input class='inputSmaller' name='monthMonday' style='width: 1.5%' type='checkbox'><p class= 'font-italic mb-4' style='display: inline-block'> &nbsp&nbsp<?=_("All the Mondays of the Month")?></p><br>
                <input class='inputSmaller' name='monthTuesday' style='width: 1.5%' type='checkbox'><p class= 'font-italic mb-4' style='display: inline-block'> &nbsp&nbsp<?=_("All the Tuesdays of the Month")?></p><br>
                <input class='inputSmaller' name='monthWednesday' style='width: 1.5%' type='checkbox'><p class= 'font-italic mb-4' style='display: inline-block'> &nbsp&nbsp<?=_("All the Wednesdays of the Month")?></p><br>
                <input class='inputSmaller' name='monthThursday' style='width: 1.5%' type='checkbox'><p class= 'font-italic mb-4' style='display: inline-block'> &nbsp&nbsp<?=_("All the Thursdays of the Month")?></p><br>
                <input class='inputSmaller' name='monthFriday' style='width: 1.5%' type='checkbox'><p class= 'font-italic mb-4' style='display: inline-block'> &nbsp&nbsp<?=_("All the Fridays of the Month")?></p><br>
                <input class='inputSmaller' name='monthSaturday' style='width: 1.5%' type='checkbox'><p class= 'font-italic mb-4' style='display: inline-block'> &nbsp&nbsp<?=_("All the Saturdays of the Month")?></p><br>
                <input class='inputSmaller' name='monthSunday' style='width: 1.5%' type='checkbox'><p class= 'font-italic mb-4' style='display: inline-block'> &nbsp&nbsp<?=_("All the Sundays of the Month")?></p><br>
            </div>
            <div id="yearForm" style="text-align: left; margin-left: 20%;display: none">
                <input class='inputSmaller' name='yearMonday' style='width: 1.5%' type='checkbox'><p class= 'font-italic mb-4' style='display: inline-block'> &nbsp&nbsp<?=_("All the first Mondays of each Month")?></p><br>
                <input class='inputSmaller' name='yearTuesday' style='width: 1.5%' type='checkbox'><p class= 'font-italic mb-4' style='display: inline-block'> &nbsp&nbsp<?=_("All the first Tuesdays of each Month")?></p><br>
                <input class='inputSmaller' name='yearWednesday' style='width: 1.5%' type='checkbox'><p class= 'font-italic mb-4' style='display: inline-block'> &nbsp&nbsp<?=_("All the first Wednesdays of each Month")?></p><br>
                <input class='inputSmaller' name='yearThursday' style='width: 1.5%' type='checkbox'><p class= 'font-italic mb-4' style='display: inline-block'> &nbsp&nbsp<?=_("All the first Thursdays of each Month")?></p><br>
                <input class='inputSmaller' name='yearFriday' style='width: 1.5%' type='checkbox'><p class= 'font-italic mb-4' style='display: inline-block'> &nbsp&nbsp<?=_("All the first Fridays of each Month")?></p><br>
                <input class='inputSmaller' name='yearSaturday' style='width: 1.5%' type='checkbox'><p class= 'font-italic mb-4' style='display: inline-block'> &nbsp&nbsp<?=_("All the first Saturdays of each Month")?></p><br>
                <input class='inputSmaller' name='yearSunday' style='width: 1.5%' type='checkbox'><p class= 'font-italic mb-4' style='display: inline-block'> &nbsp&nbsp<?=_("All the first Sundays of each Month")?></p><br>
            </div>
            <button type="submit" class="btn btn-primary btn-block2 btn-large"><?= _("Confirm")?></button>
        </form>
        <div class="card col-lg-6" style="width: 18rem;padding-left: 0px;left: 75%;top: 100%;position: absolute">
            <div class="card-header">
                <?=_("Price")?> <span title="<?= _('Estimated price if you all the checkboxes.')?>">*</span>
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
        <h2><?= _("List of all the Services we currently provide :")?></h2>
        <br>
        <input class='form-control mb-4' id='serviceSearch' type='text'
               placeholder='<?=_("Type something to search list items")?>'>
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

