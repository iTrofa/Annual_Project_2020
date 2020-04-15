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
    <link rel="stylesheet" href="css/styles.css">
    <link href="https://fonts.googleapis.com/css?family=Lato|Poppins&display=swap" rel="stylesheet">
    <title>Subscriptions - Flash Assistance</title>
    <script src="header.js"></script>
    <script src="footer.js"></script>
</head>
<body onload="checkFooter()">
<?php

include('header.php');
?>
<br>
<div class="container" style="margin-top: 7%;">
    <section class="price-comparison">
    <?php
    $DbManager = App::getDb();
    $q = $DbManager->query('SELECT * FROM subscription ORDER BY subscription.subPrice ASC');
    $res = $q->fetchAll();
    for($i=0, $iMax = count($res); $i< $iMax; $i++){
        if($res[$i]['nameSub'] !== 'Professional'){
        echo "<div class='price-column'>";
            }else{
        echo "<div class='price-column popular'>";
            }
    ?>
            <div class="price-header">
                <div class="price">
                    <div class="dollar-sign">$</div>
                            <?=$res[$i]['subPrice']?>
                    <div class="per-month">/mo</div>
                </div>
                <div class="plan-name"><?=$res[$i]['nameSub']?></div>
                </div>
                <div class="divider"></div>
        <?php
        if(empty($res[$i]['featureA']))
        {
            echo "<div class='feature inactive'>";
                    echo "<img src='images/x-square.svg'>";
                        echo $res[(count($res)-1)]['featureA'];
            echo "</div>";
        }else {
            echo "<div class='feature'>";
                echo "<img src='images/check-circle.svg'>";
                    echo $res[$i]['featureA'];
            echo "</div>";
        }

         if(empty($res[$i]['featureB']))
        {
            echo "<div class='feature inactive'>";
                    echo "<img src='images/x-square.svg'>";
                        echo $res[(count($res)-1)]['featureB'];
            echo "</div>";
        }else {
            echo "<div class='feature'>";
                echo "<img src='images/check-circle.svg'>";
                    echo $res[$i]['featureB'];
            echo "</div>";
        }
          if(empty($res[$i]['featureC']))
        {
            echo "<div class='feature inactive'>";
                    echo "<img src='images/x-square.svg'>";
                        echo $res[(count($res)-1)]['featureC'];
            echo "</div>";
        }else {
            echo "<div class='feature'>";
                echo "<img src='images/check-circle.svg'>";
                    echo $res[$i]['featureC'];
            echo "</div>";
        }
           if(empty($res[$i]['featureD']))
        {
            echo "<div class='feature inactive'>";
                    echo "<img src='images/x-square.svg'>";
                        echo $res[(count($res)-1)]['featureD'];
            echo "</div>";
        }else {
            echo "<div class='feature'>";
                echo "<img src='images/check-circle.svg'>";
                    echo $res[$i]['featureD'];
            echo "</div>";
        }
            if(empty($res[$i]['featureE']))
        {
            echo "<div class='feature inactive'>";
                    echo "<img src='images/x-square.svg'>";
                        echo $res[(count($res)-1)]['featureE'];
            echo "</div>";
        }else {
            echo "<div class='feature'>";
                echo "<img src='images/check-circle.svg'>";
                    echo $res[$i]['featureE'];
            echo "</div>";
        }
             if(empty($res[$i]['featureF']))
        {
            echo "<div class='feature inactive'>";
                    echo "<img src='images/x-square.svg'>";
                        echo $res[(count($res)-1)]['featureF'];
            echo "</div>";
        }else {
            echo "<div class='feature'>";
                echo "<img src='images/check-circle.svg'>";
                    echo $res[$i]['featureF'];
            echo "</div>";
        }

            $idSub = $res[$i]['idSub'];
            echo "<form method='get' action='paymentSub.php'>";
            echo "<input name='idSub' type='hidden' value='$idSub'>";
            echo "<button class='cta'>Start Today</button>";
            echo "</form>";

        echo "</div>";
    } ?>
    </div>
  </section>
</div>
<br><br>
<?php
include('footer.php'); ?>
</body>
</html>

