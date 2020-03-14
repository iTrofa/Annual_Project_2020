<?php
require('config.php');

require_once 'AddServiceValidator.php';

if (!empty($_POST)) {
    $validate = new AddServiceValidator($_POST);

    $validate->validateEmptyInputs();

}
?>
    <head>
        <title>Services - Flash Assistance</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
              integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh"
              crossorigin="anonymous">
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
while ($user = $req->fetch()) {
    $results[] = $user;
}
$q = $db->prepare("SELECT category from service");
$q->execute();
$serviceCat = $q->fetchall();
?>
    <div class="container" id="mainContainer" style="display: block;">
        <input type="button" class="btn-large btn-primary btn" onclick="back2back()" style="color: black;width: 15%"
               value="Check List"</input>
        <h2 style="text-align: center">Add a Service :</h2>
        <br>
        <span style="text-align: center ; display: none; color: red; font-weight: bold; text-transform: capitalize"
              id="errorSpan"></span>
        <?php if (!empty($_POST) && isset($_POST['submitService'])) {
            if (!empty($_POST['cat']) && !empty($_POST['serviceName']) && !empty($_POST['image']) && !empty($_POST['price'])) {
                $_POST['price'] *= 8;
                $q = $db->prepare("SELECT idCategory from categoryservice where nameCategory = :cat");
                $q->bindParam(":cat", $_POST['cat']);
                $q->execute();
                $res = $q->fetchAll();
                if (!empty($res)) {
                    $finalCategory = $res[0]['idCategory'];
                } else {
                    $idCategory = v4();
                    $q = $db->prepare("INSERT INTO categoryservice(idCategory, nameCategory) VALUES (:idCategory, :nameCategory)");
                    $q->bindParam(":idCategory", $idCategory);
                    $q->bindParam(":nameCategory", $_POST['cat']);
                    $q->execute();
                    $finalCategory = $idCategory;
                }
                $q = $db->prepare("SELECT name FROM service where name = :name");
                $q->bindParam(':name', $_POST['serviceName']);
                $q->execute();
                $name = $q->fetchAll();
                if (empty($name)) {
                    if (isset($_POST['demo'])) {
                        echo $_POST['demo'] . " ";
                        $q = $db->prepare("INSERT INTO service(name, image, demo, price, category ) VALUES (:name, :image, :demo, :price, :category)");
                        $q->bindParam(':name', $_POST['serviceName']);
                        $q->bindParam(':image', $_POST['image']);
                        $q->bindParam(':demo', $_POST['demo']);
                        $q->bindParam(':price', $_POST['price']);
                        $q->bindParam(':category', $finalCategory);
                        $q->Execute();
                    }
                    echo '<script type="text/javascript">';
                    echo 'checkFields(1)';
                    echo '</script>';
                    $q = $db->prepare("INSERT INTO service(idService, name, image, price, category ) VALUES (:id, :name, :image, :price, :category)");
                    $id = v4();
                    $q->bindParam(':id', $id);
                    $q->bindParam(':name', $_POST['serviceName']);
                    $q->bindParam(':image', $_POST['image']);
                    $q->bindParam(':price', $_POST['price']);
                    $q->bindParam(':category', $_POST['cat']);
                    $q->Execute();
                }
            }else {
                echo '<script type="text/javascript">';
                echo 'checkFields(0)';
                echo '</script>';
            }
        }
        ?>
        <br>
        <form style="text-align: center" method="post">
            <label>Service Category</label>
            <br>
            <select id="existingCat" onclick="serviceCategory()">
                <option>--Existing--</option>
                <?php
                $finalServiceCat = array_unique($serviceCat);
                var_dump($finalServiceCat);
                for ($i = 0; $i < sizeof($serviceCat); $i++) {
                    echo "<option>" . $serviceCat[$i]['category'] . "</option>";
                } ?>
            </select>
            <input type="text" name="cat" id="newServiceCat"
                   placeholder="Write here if New OR Select from Existing list on the Left. Exemple: Gardening">
            <br>
            <label>Service Name</label>
            <br>
            <input type="text" name="serviceName" placeholder="Exemple: Child Care">
            <br>
            <label>Service Image</label>
            <br>
            <input type="file" name="image">
            <br>
            <label>Service Price</label>
            <br>
            <input type="number" step="0.50" name="price" placeholder="Price per hour in €">
            <br>
            <label>Demo</label>
            <div class="form-check">
                <input type="checkbox" name="demo" style="width: 1%" class="form-check-input">
            </div>
            <br>
            <input type="submit" name="submitService" class="btn-large btn-primary btn" value="Add Service">
        </form>
        <br><br><br>
    </div>
    <input type="hidden" id="newServ">
    <div class="container" style="display:none;" id="hiddenContainer">
        <?php
        if (!empty($_GET)) {
            /*if($_GET['new'] == 0){
                echo "<h2><span style='color: green'>Service Added</span></h2>";
            }*/
        }
        ?>
        <br>
        <h2>List of all the Services we currently provide :</h2>
        <br>
        <input class='form-control mb-4' id='serviceSearch' type='text'
               placeholder='Type something to search list items'>
        <input type="button" class="btn-large btn-primary btn" onclick="hideServices()" style="color: black;width: 15%"
               value="Add a Service"</input>
        <br><br>
        <div class="row">
            <?php
            for ($i = 0; $i < sizeof($results); $i++) {
                $service = $results[$i]['name'];
                $servicedemo = $results[$i]['demo'];
                $serviceid = $results[$i]['idService'];
                $serviceImage = $results[$i]['image'];
                $servicefinal = strtolower($service);
                $servicefinal = trim($servicefinal);
                $servicefinal = str_replace(' ', '', $servicefinal);
                echo "<div class='col-md-4 col'>";
                echo "<div class='thumbnail'>";
                $image = "images/" . $serviceImage;
                echo "<a href=$image>";
                echo "<img src='$image' alt='$servicefinal' style='width:100%'>";
                echo "<div class='caption'>";
                echo "<p>" . $service . "</p>";
                echo "</div>";
                echo "</a>";
                echo "</div>";
                echo "</div>";
            }
            ?>
        </div>
    </div>
    <br>

<?php
echo "</body>";
include("footer.php");
?>