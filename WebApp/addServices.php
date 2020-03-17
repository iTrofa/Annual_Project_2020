<?php
require('DbManager.php');

require_once 'AddServiceValidator.php';

if (!empty($_POST))
{
    $validate = new AddServiceValidator($_POST,$_FILES);

    $validate->validateInputs();


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
    <script src="category.js"></script>
    <script src="footer.js" defer></script>
</head>
<body onload='checkFooter()'>

<?php

include('header.php');
echo "<br><br><br><br>";
if (session_status() === PHP_SESSION_NONE)
{
    session_start();
}
//List of Workers
$q = "SELECT * FROM service";
$DbManager = new  DbManager();
$req = $DbManager->getDb()->query($q);

$results = [];
while ($user = $req->fetch())
{
    $results[] = $user;
}
$q = $DbManager->getDb()->query("SELECT idCategory,nameCategory from categoryservice");
$category = $q->fetchall();
?>
<div class="container" id="mainContainer" style="display: block;">
    <input type="button" class="btn-large btn-primary btn" onclick="back2back()" style="color: black;width: 15%"
           value="Check List"><br><br>
    <input type="button" name="display"  class="btn-large btn-primary btn" onclick="displayCategory(this)" style="color: black;width:
    15%" value="Add Category">
    <br>
    <br>
        <form id="formCategory" style="display:none;">
            <span id="replyCategory"></span><br>
            <label>Category Name
            <input type="text"  placeholder="category name" name="categoryName" required><br><br>
            </label><br>
            <input type="button" class="btn-large btn-primary btn" name="submit" value="Add Category" style="color: black;width: 15%"
                   onclick="addCategory()">
        </form>
    <h2 style="text-align: center">Add a Service :</h2>
    <br>

    <form style="text-align: center" method="post" enctype="multipart/form-data">
        <h4 ><?php echo $_SESSION['valid']['request']  ?? '';
            echo $_SESSION['error']['request'] ?? '';
            if(isset($_SESSION['valid']['request']))
                unset($_SESSION['valid'], $_SESSION['error'])?></h4>
        <label>Service Category
            <br>
            <span class="error"><?= $_SESSION['error']['category'] ?? '' ?></span>
            <br>
            <select style="width: 100%" id="existingCat" name="category" required>
                <option value="">select category</option>
                <?php
                foreach ($category as $cat):
                    ?>
                    <option value="<?= $cat['idCategory'] ?>"><?= $cat['nameCategory'] ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <br>
        <label>Service Name
            <br>
            <span class="error"><?= $_SESSION['error']['serviceName'] ?? '' ?></span>
            <br>
            <input width="100%" type="text" value="<?= $_SESSION['valid']['serviceName'] ?? '' ?>" name="serviceName"
                   placeholder="Exemple: Child Care" required>
        </label>
        <br>
        <label>Service Description
            <br>
            <span class="error"><?= $_SESSION['error']['serviceDescription'] ?? '' ?></span>
            <br>
            <textarea name="serviceDescription" required><?= $_SESSION['valid']['serviceDescription'] ?? '' ?></textarea>
        </label>
        <br>
        <label>Service Image
            <br>
            <span class="error"><?= $_SESSION['error']['image'] ?? '' ?></span>
            <br>
            <input type="file" name="image" required>
        </label>
        <br>
        <label>Service Price
            <br>            <span class="error"><?= $_SESSION['error']['price'] ?? '' ?></span>
            <br>
            <input width="100%" type="number"  step="0.01" value="<?= $_SESSION['valid']['price'] ?? '' ?>" name="price"
                   placeholder="Price per hour in €">
        </label>
        <br>
        <label>Demo
            <br>
            <input type="checkbox" name="demo" style="width: 1%" class="form-check-input">
        </label>
        <br> <br>
        <input type="submit" name="submitService" class="btn-large btn-primary btn" value="Add Service">
    </form>
    <br><br><br>
</div>
<input type="hidden" id="newServ">
<div class="container" style="display:none;" id="hiddenContainer">
    <br>
    <h2>List of all the Services we currently provide :</h2>
    <br>
    <input class='form-control mb-4' id='serviceSearch' type='text'
           placeholder='Type something to search list items'>
    <input type="button" class="btn-large btn-primary btn" onclick="hideServices()" style="color: black;width: 15%"
           value="Add a Service">
    <br><br>
    <div class="row">
        <?php
        for ($i = 0, $iMax = count($results); $i < $iMax; $i++)
        {
            $service = $results[$i]['name'];
            $servicedemo = $results[$i]['demo'];
            $serviceid = $results[$i]['idService'];
            $image = $results[$i]['image'];
            $servicefinal = strtolower($service);
            $servicefinal = trim($servicefinal);
            $servicefinal = str_replace(' ', '', $servicefinal);
            ?>
            <div class='col-md-4 col'>
                <div class='thumbnail'>
                    <a href=<?= $image ?>>
                        <img src='<?= $image ?>' alt='<?= $servicefinal ?>' style='width:100%'>
                        <div class="caption">
                            <p><?= $service ?></p>
                        </div>
                    </a>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</div>
<br>
</body>
<?php
include("footer.php");

unset($_SESSION['valid'], $_SESSION['error']);