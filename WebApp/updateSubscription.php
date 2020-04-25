<?php
require_once 'session.php';
require_once "localization.php";

$q = $DbManager->getDb()->prepare("SELECT admin FROM Person Where idPerson = ?");
$q->execute([
    $_SESSION['id']
]);
$res = $q->fetchAll();
if (!$res[0]['admin']) {
    header('Location: main.php');
    exit;
}

if (isset($_POST) && !empty($_POST)) {
    if ($_POST['subcat'] == 'Basic') {
        $q = $DbManager->getDb()->prepare("UPDATE subscription SET featureA = :featureA, featureB = :featureB WHERE nameSub = 'Basic'");
        $q->bindParam(":featureA", $_POST['featureA']);
        $q->bindParam(":featureB", $_POST['featureB']);
        $q->execute();
        $q = $DbManager->getDb()->prepare("UPDATE subscription SET featureA = :featureA, featureB = :featureB WHERE nameSub = 'Professional'");
        $q->bindParam(":featureA", $_POST['featureA']);
        $q->bindParam(":featureB", $_POST['featureB']);
        $q->execute();
        $q = $DbManager->getDb()->prepare("UPDATE subscription SET featureA = :featureA, featureB = :featureB WHERE nameSub = 'Enterprise'");
        $q->execute([
            ":featureA" => $_POST["featureA"],
            ":featureB" => $_POST["featureB"]
        ]);
    }
    if ($_POST['subcat'] == 'Professional') {
        $q = $DbManager->getDb()->prepare("UPDATE subscription SET featureA = :featureA, featureB = :featureB WHERE nameSub = 'Basic'");
        $q->bindParam(":featureA", $_POST['featureA']);
        $q->bindParam(":featureB", $_POST['featureB']);
        $q->execute();
        $q = $DbManager->getDb()->prepare("UPDATE subscription SET featureA = :featureA, featureB = :featureB, featureC = :featureC, featureD = :featureD WHERE nameSub = 'Professional'");
        $q->bindParam(":featureA", $_POST['featureA']);
        $q->bindParam(":featureB", $_POST['featureB']);
        $q->bindParam(":featureC", $_POST['featureC']);
        $q->bindParam(":featureD", $_POST['featureD']);
        $q->execute();
        $q = $DbManager->getDb()->prepare("UPDATE subscription SET featureA = :featureA, featureB = :featureB, featureC = :featureC, featureD = :featureD WHERE nameSub = 'Enterprise'");
        $q->execute([
            ":featureA" => $_POST["featureA"],
            ":featureB" => $_POST["featureB"],
            ":featureC" => $_POST["featureC"],
            ":featureD" => $_POST["featureD"]
        ]);
    }
    if ($_POST['subcat'] == 'Enterprise') {
        $q = $DbManager->getDb()->prepare("UPDATE subscription SET featureA = :featureA, featureB = :featureB WHERE nameSub = 'Basic'");
        $q->bindParam(":featureA", $_POST['featureA']);
        $q->bindParam(":featureB", $_POST['featureB']);
        $q->execute();
        $q = $DbManager->getDb()->prepare("UPDATE subscription SET featureA = :featureA, featureB = :featureB, featureC = :featureC, featureD = :featureD WHERE nameSub = 'Professional'");
        $q->bindParam(":featureA", $_POST['featureA']);
        $q->bindParam(":featureB", $_POST['featureB']);
        $q->bindParam(":featureC", $_POST['featureC']);
        $q->bindParam(":featureD", $_POST['featureD']);
        $q->execute();
        $q = $DbManager->getDb()->prepare("UPDATE subscription SET featureA = :featureA, featureB = :featureB, featureC = :featureC, featureD = :featureD, featureE = :featureE, featureF = :featureF WHERE nameSub = 'Enterprise'");
        $q->execute([
            ":featureA" => $_POST["featureA"],
            ":featureB" => $_POST["featureB"],
            ":featureC" => $_POST["featureC"],
            ":featureD" => $_POST["featureD"],
            ":featureE" => $_POST["featureE"],
            ":featureF" => $_POST["featureF"]
        ]);
    }
}
?>
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
    <link rel="stylesheet" href="css/services.css">
    <link href="https://fonts.googleapis.com/css?family=Lato|Poppins&display=swap" rel="stylesheet">
    <title>Add Subscriptions - Flash Assistance</title>
    <script src="javascript/header.js"></script>
    <script src="javascript/addSub.js"></script>
    <script src="javascript/footer.js"></script>
</head>
<body onload="checkFooter()">
<?php
require_once "header.php";
?>
<main>
    <form method="post" class="form-group" style="text-align: center;margin-top: 3%">
        <select id="addSubCat" name="subcat" onchange="addSub()">
            <option>Basic</option>
            <option>Professional</option>
            <option>Enterprise</option>
        </select>

        <div id="basicDiv" style="display: block">
            <label>Feature A</label><br>
            <input type="text" name="featureA" class="inputSmaller"><br>
            <label>Feature B</label><br>
            <input type="text" name="featureB" class="inputSmaller"><br>
        </div>

        <div id="professionalDiv" style="display:none">
            <label>Feature C</label><br>
            <input type="text" name="featureC" class="inputSmaller"><br>
            <label>Feature D</label><br>
            <input type="text" name="featureD" class="inputSmaller"><br>
        </div>

        <div id="enterpriseDiv" style="display: none">
            <label>Feature E</label><br>
            <input type="text" name="featureE" class="inputSmaller"><br>
            <label>Feature F</label><br>
            <input type="text" name="featureF" class="inputSmaller"><br>
        </div>
        <input type="submit" style="margin-top: 1%;" class="btn-large btn-primary btn"
               value="<?= _('Submit Changes') ?>">
    </form>
</main>
<?php
require_once 'footer.php';
?>
</body>
