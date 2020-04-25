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
    <link rel="stylesheet" href="css/services.css">
    <title>Flash Assistance</title>
    <script src="javascript/header.js" defer></script>
    <script src="javascript/footer.js" defer></script>
</head>
<body onload="checkFooter()">
<?php
include("header.php");
$DbManager = App::getDb();
$q = $DbManager->query("SELECT * FROM subscription WHERE idSub = ?",[
    $_GET['idSub']
]);
$res = $q->fetchAll();
?>
<main>

    <h3 style="margin-left: 10%;margin-top: 3%; color: midnightblue"><?= $res[0]['nameSub'] . ' Subscription :' ?></h3>
    <ul>
        <?php



        $finalprice = $res[0]['subPrice'];
        $finalprice2 = $finalprice + $finalprice * 0.21;
        $_SESSION['price'] = $finalprice2;
        ?>
    </ul>
    <div class="row py-5 p-4 bg-white rounded shadow-sm" style="margin-left: 0;margin-right: 0">
        </div>
        <div>
            <div class="bg-light rounded-pill px-4 py-3 text-uppercase font-weight-bold"><?=_('Order summary')?> </div>
            <div class="p-4">
                <p class="font-italic mb-4"><?=_('Tax costs are calculated based on values you have entered and each service.')?></p>
                <ul class="list-unstyled mb-4">
                    <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted"><?=_('Order Subtotal')?> </strong><strong><?=$finalprice."€"?></strong></li>
                    <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted"><?=_('Tax')?></strong><strong><?=$finalprice*0.21."€"?></strong></li>
                    <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted"><?=_('Total')?></strong>
                        <h5 class="font-weight-bold"><?=$finalprice+$finalprice*0.21.'€'?></h5>
                    </li>
                </ul><a href="stripeAPI.php?sub=<?=$_GET['idSub']?>" class="btn btn-dark rounded-pill py-2 btn-block"><?=_('Proceed to checkout')?></a>
            </div>
        </div>
    </div>
    <br><br>
</main>
<?php
include('footer.php');
?>
</body>
</html>
