<?php
require_once "session.php";
require('DbManager.php');
$service = $_GET['services'];
$DbManager = new DbManager();
$q = $DbManager->getDb()->prepare("SELECT * from service WHERE idService = :idService");
$q->bindParam(':idService', $service);
$q->execute();
$chosenService = $q->fetchAll();
if(empty($chosenService)){
    header('Location: services.php?error=noservice');
    exit;
}

function isValidUuid( $service ) {
    if (!is_string($service) || (preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/', $service) !== 1)) {
        return false;
    }
    return true;
}

if(!isValidUuid($service)) {
    header('Location: services.php');
    exit;
}
echo "<html>";
echo "<title>Services - Flash Assistance</title>";
echo "<link href='https://fonts.googleapis.com/css?family=Playfair+Display&display=swap' rel='stylesheet'>";
echo "<link rel='stylesheet' href='css/services.css'>";
?>
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
<script src="header.js" defer></script>
<script src="footer.js"defer></script>
<style>
   /* input:invalid {
        border: solid red 3px;
    }
    input:valid {
        border: solid green 3px;
    }*/
</style>
    <body onload="checkFooter()">
    <?php
    include('header.php');
    ?>
    <main>
    <?php
        echo $_POST['reservationInput'] .  " " . substr($_POST['userOption'], 0, -3) . "s " . $_POST['noinput'];

switch ($_POST['userOption']){
    case "Hour(s)":
        $timevariable = 1;
        break;
    case "Day(s)":
        $timevariable = 1*$_POST['noinput'];
        break;
    case "Month(s)":
        $timevariable = 31;
        break;
    case "Year(s)":
        $timevariable = 31*12;
        break;
}
echo $_POST['reservationInput'];
echo $timevariable;
$price = $_POST['reservationInput'] * $timevariable;
echo " " . $service;


    var_dump($chosenService);

    $price *= $chosenService[0]['price'];

?>
    
    <!--<br><br>
    <form onchange="payment()">
    <input type="date" id="reservationDate">
    <input type="date" hidden id="test" value="<?= date("Y-m-d"); ?>">
    </form>

    <div id="payementAnswer">
    </div>
    <br>
    <div id="endDates">-->

    </div>
    <div class="row py-5 p-4 bg-white rounded shadow-sm" style="margin-left: 0;margin-right: 0">
        <div class="col-lg-6">
            <div class="bg-light rounded-pill px-4 py-3 text-uppercase font-weight-bold">Coupon code</div>
            <div class="p-4">
                <p class="font-italic mb-4">If you have a subscription, please enter it in the box below</p>
                <div class="input-group mb-4 border rounded-pill p-2">
                    <select type="text" placeholder="Apply coupon" aria-describedby="button-addon3" class="form-control border-0">
                        <option>----Select your Subscription----</option>
                    </select>
                    <div class="input-group-append border-0">
                        <button id="button-addon3" type="button" class="btn btn-dark px-4 rounded-pill"><i class="fa fa-gift mr-2"></i>Apply coupon</button>
                    </div>
                </div>
            </div>
           <!-- <div class="bg-light rounded-pill px-4 py-3 text-uppercase font-weight-bold">Instructions for seller</div>
            <div class="p-4">
                <p class="font-italic mb-4">If you have some information for the seller you can leave them in the box below</p>
                <textarea name="" cols="30" rows="2" class="form-control"></textarea>
            </div>-->
        </div>
        <div class="col-lg-6">
            <div class="bg-light rounded-pill px-4 py-3 text-uppercase font-weight-bold">Order summary </div>
            <div class="p-4">
                <p class="font-italic mb-4">Tax costs are calculated based on values you have entered and each service.</p>
                <ul class="list-unstyled mb-4">
                    <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Order Subtotal </strong><strong><?=$price."€"?></strong></li>
                    <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Tax</strong><strong><?=$price*0.21."€"?></strong></li>
                    <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Total</strong>
                        <h5 class="font-weight-bold"><?=$price+$price*0.21 ."€"?></h5>
                    </li>
                </ul><a href="stripeAPI.php" class="btn btn-dark rounded-pill py-2 btn-block">Procceed to checkout</a>
            </div>
        </div>
    </div>
    <br><br>
    </main>
<?php
include ("footer.php");
?>
</body>
</html>


