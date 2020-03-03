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
<script src="addServices.js"></script>
<script src="footer.js">defer</script>
</head>
<?php
echo "<body onload='checkFooter()'>";
include('header.php');
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
?>
<div class="container" id="mainContainer">
    <h2>List of all the Services we currently provide :</h2>
    <br>
    <input class='form-control mb-4' id='serviceSearch' type='text' placeholder='Type something to search list items'>
    <input type="button" class="btn-large btn-primary btn" onclick="hideServices()" style="color: black;width: 15%" value="Add a Service"</input>
    <br><br>
    <div class="row">
        <?php
        for($i=0; $i<sizeof($results);$i++){
            $service = $results[$i]['name'];
            $servicedemo = $results[$i]['demo'];
            $serviceid = $results[$i]['idService'];
            $servicefinal = strtolower($service);
            $servicefinal = trim($servicefinal);
            $servicefinal = str_replace(' ', '', $servicefinal);
            echo "<div class='col-md-4 col'>";
                echo "<div class='thumbnail'>";
            $image = "images/".$servicefinal.".jpg";
                    echo "<a href=$image>";
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
    <br>
    <div class="container" id="hiddenContainer" style="display: none;">
        <input type="button" class="btn-large btn-primary btn" onclick="back2back()" style="color: black;width: 15%" value="Go Back"</input>
        <br><br><br>
        <h2>Add a Service :</h2>
        <br><br>
        <form>
            <label>Service Category</label>
            <br>
            <input type="text">
            <br>
            <label>Service Name</label>
            <br>
            <input type="text">
            <br>
            <label>Service Image</label>
            <br>
            <input type="file">
            <br>
            <label>Demo</label>
            <div class="form-check">
            <input type="checkbox" style="width: 1%" class="form-check-input">
            </div>
        </form>
        <br><br>

    </div>
<?php
 echo "</body>";
include ("footer.php");



