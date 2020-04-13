<?php
require_once "session.php";
if(isset($_GET['services']))
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

if(!isValidUuid($service) && !isset($_GET['cart0'])) {
    header('Location: services.php');
    exit;
}
echo "<html>";
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
<script src="footer.js" defer></script>
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
if(isset($_POST['userOption'])) {
    switch ($_POST['userOption']) {
        case "Hour(s)":
            $timevariable = 1 / 8;
            if(isset($_POST['hourInput']))
                $date = $_POST['hourInput'];
            break;
        case "Day(s)":
            $timevariable = 1 / 8 * $_POST['noinput'];
            if(isset($_POST['Monday']))
                $week1 = $_POST['Monday'];
            if(isset($_POST['Tuesday']))
                $week2 = $_POST['Tuesday'];
            if(isset($_POST['Wednesday']))
                $week3 = $_POST['Wednesday'];
            if(isset($_POST['Thursday']))
                $week4 = $_POST['Thursday'];
            if(isset($_POST['Friday']))
                $week5 = $_POST['Friday'];
            if(isset($_POST['Saturday']))
                $week6 = $_POST['Saturday'];
            if(isset($_POST['Sunday']))
                $week7 = $_POST['Sunday'];
            break;
        case "Month(s)":
            if(isset($_POST['monthMonday']))
                $month1 = $_POST['monthMonday'];
            if(isset($_POST['monthTuesday']))
                $month2 = $_POST['monthTuesday'];
            if(isset($_POST['monthWednesday']))
                $month3 = $_POST['monthWednesday'];
            if(isset($_POST['monthThursday']))
                $month4 = $_POST['monthThursday'];
            if(isset($_POST['monthFriday']))
                $month5 = $_POST['monthFriday'];
            if(isset($_POST['monthSaturday']))
                $month6 = $_POST['monthSaturday'];
            if(isset($_POST['monthSunday']))
                $month7 = $_POST['monthSunday'];
            $timevariable = 31;
            break;
        case "Year(s)":
            if(isset($_POST['yearMonday']))
                $year1 = $_POST['yearMonday'];
            if(isset($_POST['yearTuesday']))
                $year2 = $_POST['yearTuesday'];
            if(isset($_POST['yearWednesday']))
                $year3 = $_POST['yearWednesday'];
            if(isset($_POST['yearThursday']))
                $year4 = $_POST['yearThursday'];
            if(isset($_POST['yearFriday']))
                $year5 = $_POST['yearFriday'];
            if(isset($_POST['yearSaturday']))
                $year6 = $_POST['yearSaturday'];
            if(isset($_POST['yearSunday']))
                $year7 = $_POST['yearSunday'];
            $timevariable = 31 * 12;
            break;
    }
    $userOption = $_POST['userOption'];
    $firstInput = $_POST['reservationInput'];
    $secondInput = $_POST['noinput'];
}
    $DbPrice = $chosenService[0]['price'];
    $price = $_POST['reservationInput'] * $timevariable;
    $price *= $chosenService[0]['price'];
    $finalprice = $price+$price*0.21;
?>

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
                <?php
                switch ($_POST['userOption']) {
                    case "Hour(s)":
                        echo "<a href=\"cart.php?service=$service&package=$userOption&date=$date&hour=$firstInput\" class=\"btn btn-dark rounded-pill py-2 btn-block\">Add to Cart</a>";
                        break;

                    case "Day(s)":
                            echo "<a href=\"cart.php?service=$service&package=$userOption&day=$firstInput&hour=$secondInput&date1=$week1&date2=$week2&date3=$week3&date4=$week4&date5=$week5&date6=$week6&date7=$week7\" class=\"btn btn-dark rounded-pill py-2 btn-block\">Add to Cart</a>";
                        break;

                    case "Month(s)":
                            echo "<a href=\"cart.php?service=$service&package=$userOption&day=$firstInput&hour=$secondInput&date1=$month1&date2=$month2&date3=$month3&date4=$month4&date5=$month5&date6=$month6&date7=$month7\" class=\"btn btn-dark rounded-pill py-2 btn-block\">Add to Cart</a>";
                        break;

                    case "Year(s)":
                            echo "<a href=\"cart.php?service=$service&package=$userOption&day=$firstInput&hour=$secondInput&date1=$year1&date2=$year2&date3=$year3&date4=$year4&date5=$year5&date6=$year6&date7=$year7\" class=\"btn btn-dark rounded-pill py-2 btn-block\">Add to Cart</a>";
                        break;

                }
                ?>
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
                        <h5 class="font-weight-bold"><?=$finalprice."€"?></h5>
                    </li>
                    <?php
                    switch ($_POST['userOption']) {
                        case "Hour(s)":
                            echo "<a href=\"expressPay.php?service=$service&package=$userOption&date=$date&hour=$firstInput\" class=\"btn btn-dark rounded-pill py-2 btn-block\">Proceed to Checkout</a>";
                            break;

                        case "Day(s)":
                            echo "<a href=\"expressPay.php?service=$service&package=$userOption&day=$firstInput&hour=$secondInput&date1=$week1&date2=$week2&date3=$week3&date4=$week4&date5=$week5&date6=$week6&date7=$week7\" class=\"btn btn-dark rounded-pill py-2 btn-block\">Proceed to Checkout</a>";
                            break;

                        case "Month(s)":
                            echo "<a href=\"expressPay.php?service=$service&package=$userOption&day=$firstInput&hour=$secondInput&date1=$month1&date2=$month2&date3=$month3&date4=$month4&date5=$month5&date6=$month6&date7=$month7\" class=\"btn btn-dark rounded-pill py-2 btn-block\">Proceed to Checkout</a>";
                            break;

                        case "Year(s)":
                            echo "<a href=\"expressPay.php?service=$service&package=$userOption&day=$firstInput&hour=$secondInput&date1=$year1&date2=$year2&date3=$year3&date4=$year4&date5=$year5&date6=$year6&date7=$year7\" class=\"btn btn-dark rounded-pill py-2 btn-block\">Proceed to Checkout</a>";
                            break;

                    }
                    ?>
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


