
    <!--<link rel="stylesheet" href="css/styles.css">
    <link href="https://fonts.googleapis.com/css?family=Lato|Poppins&display=swap" rel="stylesheet">
    <title>Price Comparison Table</title>-->




<?php
if (session_status() == PHP_SESSION_NONE)
{
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
    <title>Price Comparison Table</title>
    <script src="header.js"></script>
    <script src="footer.js"></script>
</head>
<body onload="checkFooter()">
<?php

include('header.php');
?>
<br><br>
<div class="container">
    <section class="price-comparison">
    <div class="price-column">
      <div class="price-header">
        <div class="price">
          <div class="dollar-sign">$</div>
          10
          <div class="per-month">/mo</div>
        </div>
        <div class="plan-name">Basic</div>
      </div>
      <div class="divider"></div>
      <div class="feature">
        <img src="images/check-circle.svg">
        Feature A
      </div>
      <div class="feature">
        <img src="images/check-circle.svg">
        Feature B
      </div>
      <div class="feature inactive">
        <img src="images/x-square.svg">
        Feature C
      </div>
      <div class="feature inactive">
        <img src="images/x-square.svg">
        Feature D
      </div>
      <div class="feature inactive">
        <img src="images/x-square.svg">
        Feature E
      </div>
      <div class="feature inactive">
        <img src="images/x-square.svg">
        Feature F
      </div>
      <button class="cta">Start Today</button>
    </div>
    <div class="price-column popular">
      <div class="most-popular">Most Popular</div>
      <div class="price-header">
        <div class="price">
          <div class="dollar-sign">$</div>
          20
          <div class="per-month">/mo</div>
        </div>
        <div class="plan-name">Professional</div>
      </div>
      <div class="divider"></div>
      <div class="feature">
        <img src="images/check-circle.svg">
        Feature A
      </div>
      <div class="feature">
        <img src="images/check-circle.svg">
        Feature B
      </div>
      <div class="feature">
        <img src="images/check-circle.svg">
        Feature C
      </div>
      <div class="feature">
        <img src="images/check-circle.svg">
        Feature D
      </div>
      <div class="feature inactive">
        <img src="images/x-square.svg">
        Feature E
      </div>
      <div class="feature inactive">
        <img src="images/x-square.svg">
        Feature F
      </div>
      <button class="cta">Start Today</button>
    </div>
    <div class="price-column">
      <div class="price-header">
        <div class="price">
          <div class="dollar-sign">$</div>
          50
          <div class="per-month">/mo</div>
        </div>
        <div class="plan-name">Enterprise</div>
      </div>
      <div class="divider"></div>
      <div class="feature">
        <img src="images/check-circle.svg">
        Feature A
      </div>
      <div class="feature">
        <img src="images/check-circle.svg">
        Feature B
      </div>
      <div class="feature">
        <img src="images/check-circle.svg">
        Feature C
      </div>
      <div class="feature">
        <img src="images/check-circle.svg">
        Feature D
      </div>
      <div class="feature">
        <img src="images/check-circle.svg">
        Feature E
      </div>
      <div class="feature">
        <img src="images/check-circle.svg">
        Feature F
      </div>
      <button class="cta">Start Today</button>
    </div>
  </section>
</div>
<br><br>
<?php
include("footer.php"); ?>
</body>
</html>

