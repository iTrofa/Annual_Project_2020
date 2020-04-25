<?php
require_once "session.php";
if(isset($_GET['services']))
    $service = $_GET['services'];

$DbManager = App::getDb();
$q = $DbManager->query('SELECT * from service WHERE idService = :idService',
    [':idService' => $service]);
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

function getDates($duration, $option)
{
    if (date('N', time()) == $option) {
        $j = 0;
    } else {
        for ($i = 1; $i < 8; $i += 1) {
            if (date('N', time() + ($i * 24 * 60 * 60)) == $option) {
                $j = $i;
                break;
            }
        }
    }
    $count = 0;
    for ($i = $j; $i < $duration; $i += 7) {
        $count += 1;
    }
    return $count;
}

echo "<html>";
echo "<link href='https://fonts.googleapis.com/css?family=Playfair+Display&display=swap' rel='stylesheet'>";
echo "<link rel='stylesheet' href='../css/services.css'>";
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
<script src="javascript/header.js" defer></script>
<script src="javascript/footer.js" defer></script>
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
                if(isset($_POST['hourInput']))
                    $date = $_POST['hourInput'];
                $price = $_POST['reservationInput'] * $chosenService[0]['price'] * 1/8;
                break;
            case "Day(s)":
                if($_POST['reservationInput'] <= 7) {
                    $price = $_POST['noinput'] * $chosenService[0]['price'] * 1 / 8;
                    $options = 0;
                }else{
                    $price = $_POST['noinput'] * $_POST['reservationInput'] * $chosenService[0]['price'] * 1/8;
                }
                if(isset($_POST['Monday'])) {
                    $week1 = $_POST['Monday'];
                    if($_POST['reservationInput'] <= 7) {
                        $options += 1;
                    }
                }else $week1 = '';
                if(isset($_POST['Tuesday'])) {
                    $week2 = $_POST['Tuesday'];
                    if ($_POST['reservationInput'] <= 7) {
                        $options += 1;
                    }
                }
                else $week2 = '';
                if(isset($_POST['Wednesday'])) {
                    $week3 = $_POST['Wednesday'];
                    if ($_POST['reservationInput'] <= 7) {
                        $options += 1;
                    }
                }
                else $week3 = '';
                if(isset($_POST['Thursday'])) {
                    $week4 = $_POST['Thursday'];
                    if ($_POST['reservationInput'] <= 7) {
                        $options += 1;
                    }
                }
                else $week4 = '';
                if(isset($_POST['Friday'])) {
                    $week5 = $_POST['Friday'];
                    if ($_POST['reservationInput'] <= 7) {
                        $options += 1;
                    }
                }
                else $week5 = '';
                if(isset($_POST['Saturday'])) {
                    $week6 = $_POST['Saturday'];
                    if ($_POST['reservationInput'] <= 7) {
                        $options += 1;
                    }
                }
                else $week6 = '';
                if(isset($_POST['Sunday'])) {
                    $week7 = $_POST['Sunday'];
                    if ($_POST['reservationInput'] <= 7) {
                        $options += 1;
                    }
                }
                else $week7 = '';
                if($_POST['reservationInput'] <= 7) {
                    $price *= $options;
                }
                break;
            case "Month(s)":
                $price = $_POST['noinput'] * $chosenService[0]['price'] * 1 / 8;
                $options = 0;
                if(isset($_POST['monthMonday'])) {
                    $options += getDates(31 * $_POST['reservationInput'], 1);
                    $month1 = $_POST['monthMonday'];
                }
                else $month1 = '';
                if(isset($_POST['monthTuesday'])) {
                    $options += getDates(31 * $_POST['reservationInput'], 2);
                    $month2 = $_POST['monthTuesday'];
                }
                else $month2 = '';
                if(isset($_POST['monthWednesday'])) {
                    $options += getDates(31 * $_POST['reservationInput'], 3);
                    $month3 = $_POST['monthWednesday'];
                }
                else $month3 = '';
                if(isset($_POST['monthThursday'])) {
                    $options += getDates(31 * $_POST['reservationInput'], 4);
                    $month4 = $_POST['monthThursday'];
                }
                else $month4 = '';
                if(isset($_POST['monthFriday'])) {
                    $options += getDates(31 * $_POST['reservationInput'], 5);
                    $month5 = $_POST['monthFriday'];
                }
                else $month5 = '';
                if(isset($_POST['monthSaturday'])) {
                    $options += getDates(31 * $_POST['reservationInput'], 6);
                    $month6 = $_POST['monthSaturday'];
                }
                else $month6 = '';
                if(isset($_POST['monthSunday'])) {
                    $options += getDates(31 * $_POST['reservationInput'], 7);
                    $month7 = $_POST['monthSunday'];
                }
                else $month7 = '';
                $price *= $options;
                break;
            case "Year(s)":
                $price = $_POST['noinput'] * $chosenService[0]['price'] * 1 / 8;
                $options = 0;
                if(isset($_POST['yearMonday'])) {
                    $options += getDates(31 * 12 * $_POST['reservationInput'], 1);
                    $year1 = $_POST['yearMonday'];
                }
                else $year1 = '';
                if(isset($_POST['yearTuesday'])) {
                    $options += getDates(31 * 12 * $_POST['reservationInput'], 2);
                    $year2 = $_POST['yearTuesday'];
                }
                else $year2 = '';
                if(isset($_POST['yearWednesday'])) {
                    $options += getDates(31 * 12 * $_POST['reservationInput'], 3);
                    $year3 = $_POST['yearWednesday'];
                }
                else $year3 = '';
                if(isset($_POST['yearThursday'])) {
                    $options += getDates(31 * 12 * $_POST['reservationInput'], 4);
                    $year4 = $_POST['yearThursday'];
                }
                else $year4 = '';
                if(isset($_POST['yearFriday'])) {
                    $options += getDates(31 * 12 * $_POST['reservationInput'], 5);
                    $year5 = $_POST['yearFriday'];
                }
                else $year5 = '';
                if(isset($_POST['yearSaturday'])) {
                    $options += getDates(31 * 12 * $_POST['reservationInput'], 6);
                    $year6 = $_POST['yearSaturday'];
                }
                else $year6 = '';
                if(isset($_POST['yearSunday'])) {
                    $options += getDates(31 * 12 * $_POST['reservationInput'], 7);
                    $year7 = $_POST['yearSunday'];
                }
                else $year7 = '';
                $price *= $options;
                break;
        }
        $userOption = $_POST['userOption'];
        $firstInput = $_POST['reservationInput'];
        $secondInput = $_POST['noinput'];
    }
    $DbPrice = $chosenService[0]['price'];
    $finalPrice = $price+$price*0.21;

    $q = $DbManager->getDb()->prepare("SELECT subscription, nameSub FROM person LEFT JOIN subscription on person.subscription = subscription.idSub  WHERE idPerson = ?");
    $q->execute([
        $_SESSION['id']
    ]);
    $Sub = $q->fetchAll();
    $nameSub = $Sub[0]['nameSub'];

    ?>

    </div>
    <div class="row py-5 p-4 bg-white rounded shadow-sm" style="margin-left: 0;margin-right: 0">
        <div class="col-lg-6">
            <div class="bg-light rounded-pill px-4 py-3 text-uppercase font-weight-bold"><?=_('Coupon code')?></div>
            <div class="p-4">
                <?php
                if(isset($nameSub)){
                    switch ($nameSub) {
                        case "Basic":
                            $nameSub = "Basic";
                            $valueSub = 0.8;
                            break;
                        case "Professional":
                            $nameSub = "Professional";
                            $valueSub = 0.6;
                            break;
                        case "Enterprise" :
                            $nameSub = "Enterprise";
                            $valueSub = 0.4;
                            break;
                    }
                    ?>
                    <p class="font-italic mb-4"><?=_('You have the ' . $nameSub . " Subscription")?></p>
                    <div class="input-group mb-4 border rounded-pill p-2">
                        <input type="text" aria-describedby="button-addon3" class="form-control border-0" value="<?='The old price was '.$finalPrice.' now it\'s ' . $finalPrice * $valueSub?>">
                        <div class="input-group-append border-0">
                            <a href="../subscription.php"><button id="button-addon3" type="button" class="btn btn-dark px-4 rounded-pill"><i class="fa fa-gift mr-2"></i><?=_('Look at our other Subscriptions')?></button></a>
                        </div>
                    </div>
                    <?php
                }else{
                    ?>
                    <p class="font-italic mb-4"><?=_('If you have a subscription, please enter it in the box below')?></p>
                    <div class="input-group mb-4 border rounded-pill p-2">
                        <input type="text" aria-describedby="button-addon3" class="form-control border-0">
                        <div class="input-group-append border-0">
                            <button id="button-addon3" type="button" class="btn btn-dark px-4 rounded-pill"><i class="fa fa-gift mr-2"></i><?=_('Apply coupon')?></button>
                        </div>
                    </div>
                    <?php
                }
                $addCart = _("Add to cart");
                switch ($_POST['userOption']) {
                    case "Hour(s)":
                        echo "<a href=\"cart.php?service=$service&package=$userOption&date=$date&hour=$firstInput\" class=\"btn btn-dark rounded-pill py-2 btn-block\">$addCart</a>";
                        break;

                    case "Day(s)":
                        echo "<a href=\"cart.php?service=$service&package=$userOption&day=$firstInput&hour=$secondInput&date1=$week1&date2=$week2&date3=$week3&date4=$week4&date5=$week5&date6=$week6&date7=$week7\" class=\"btn btn-dark rounded-pill py-2 btn-block\">$addCart</a>";
                        break;

                    case "Month(s)":
                        echo "<a href=\"cart.php?service=$service&package=$userOption&day=$firstInput&hour=$secondInput&date1=$month1&date2=$month2&date3=$month3&date4=$month4&date5=$month5&date6=$month6&date7=$month7\" class=\"btn btn-dark rounded-pill py-2 btn-block\">$addCart</a>";
                        break;

                    case "Year(s)":
                        echo "<a href=\"cart.php?service=$service&package=$userOption&day=$firstInput&hour=$secondInput&date1=$year1&date2=$year2&date3=$year3&date4=$year4&date5=$year5&date6=$year6&date7=$year7\" class=\"btn btn-dark rounded-pill py-2 btn-block\">$addCart</a>";
                        break;

                }
                ?>
            </div>

        </div>
        <div class="col-lg-6">
            <div class="bg-light rounded-pill px-4 py-3 text-uppercase font-weight-bold"><?=_('Order summary')?></div>
            <div class="p-4">
                <p class="font-italic mb-4"><?=_('Tax costs are calculated based on values you have entered and each service')?>.</p>
                <ul class="list-unstyled mb-4">
                    <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted"><?=_('Order Subtotal')?> </strong><strong><?=$price."€"?></strong></li>
                    <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted"><?=_('Tax')?></strong><strong><?=$price*0.21."€"?></strong></li>
                    <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted"><?=_('Total')?></strong>
                        <?php
                        if(isset($valueSub)){
                        ?>
                        <h5 style="text-decoration: line-through" class="font-weight-bold"><?=$finalPrice."€"?></h5>
                    <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted"><?=_('New Total')?></strong>

                        <h5 class="font-weight-bold"><?=$finalPrice*$valueSub."€"?></h5>
                        <?php
                        }else{
                            ?>
                            <h5 class="font-weight-bold"><?=$finalPrice."€"?></h5>
                            <?php
                        }
                        ?>
                    </li>
                    <?php
                    $proceedCheck = _('Proceed to Checkout');
                    switch ($_POST['userOption']) {
                        case "Hour(s)":
                            echo "<a href=\"expressPay.php?service=$service&package=$userOption&date=$date&hour=$firstInput\" class=\"btn btn-dark rounded-pill py-2 btn-block\">$proceedCheck</a>";
                            break;

                        case "Day(s)":
                            echo "<a href=\"expressPay.php?service=$service&package=$userOption&day=$firstInput&hour=$secondInput&date1=$week1&date2=$week2&date3=$week3&date4=$week4&date5=$week5&date6=$week6&date7=$week7\" class=\"btn btn-dark rounded-pill py-2 btn-block\">$proceedCheck</a>";
                            break;

                        case "Month(s)":
                            echo "<a href=\"expressPay.php?service=$service&package=$userOption&day=$firstInput&hour=$secondInput&date1=$month1&date2=$month2&date3=$month3&date4=$month4&date5=$month5&date6=$month6&date7=$month7\" class=\"btn btn-dark rounded-pill py-2 btn-block\">$proceedCheck</a>";
                            break;

                        case "Year(s)":
                            echo "<a href=\"expressPay.php?service=$service&package=$userOption&day=$firstInput&hour=$secondInput&date1=$year1&date2=$year2&date3=$year3&date4=$year4&date5=$year5&date6=$year6&date7=$year7\" class=\"btn btn-dark rounded-pill py-2 btn-block\">$proceedCheck</a>";
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

