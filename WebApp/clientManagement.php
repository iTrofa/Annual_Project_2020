<?php
require_once "session.php";
require_once "localization.php";
$q =$DbManager->getDb()->prepare("SELECT admin FROM Person Where idPerson = ?");
$q->execute([
    $_SESSION['id']
]);
$res = $q->fetchAll();
if(!$res[0]['admin']){
    header('Location: main.php');
    exit;
}
if (isset($_POST['add_admin'])) {
    $q = $DbManager->getDb()->prepare("UPDATE Person SET admin = 1 WHERE idPerson = ?");
    $q->execute([
        $_POST['add_admin']
    ]);
    if($q->rowCount() > 0) {
        $return['success'] = "New Admin Added";
    }else{
        $return['success'] = 'No Admin Added check if the Id exists or if there are no spaces at the end of entered Id';
    }
}
if (isset($_POST['remove_admin'])) {
    $q = $DbManager->getDb()->prepare("UPDATE Person SET admin = 0 WHERE idPerson = ?");
    $q->execute([
        $_POST['remove_admin']
    ]);
    if($q->rowCount() > 0) {
        $return['remove'] = "Admin Removed";
    }else{
        $return['remove'] = "No Admin Removed check if the Id exists or if there are no spaces at the end of entered Id";
    }
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
    <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>-->
    <link rel="stylesheet" href="css/main.css">
    <title><?= _("Client Management - Flash Assistance") ?></title>
    <script src="header.js"></script>
    <script src="footer.js"></script>
</head>
<body onload="checkFooter()">
<?php
require "header.php";
?>
<main>
    <?php
    //List of Workers
    $DbManager = new  DbManager();
    $q = "SELECT * FROM person";
    $req = $DbManager->getDb()->query($q);
    $req->execute();
    $results = $req->fetchAll();
    ?>

    <div class="container">
        <?php
        if (isset($return['success'])) {
            echo $return['success'];
        }
        if (isset($return['remove'])) {
            echo $return['remove'];
        }
        ?>
        <div class="row">
            <div class="col-md-6">
                <form method="post" style="padding-top: 5%">
                    <h2>Add an Admin</h2>
                    <input type="text" style="width: 80%"
                           placeholder="Please enter the ID of person you want to add as an Admin" name="add_admin">
                    <input class="btn btn-primary btn-large" type="submit" value="Add new Admin" style="margin-top: 3%">
                </form>
            </div>
            <div class="col-md-6">
                <form method="post" style="padding-top: 5%">
                    <h2>Remove an Admin</h2>
                    <input type="text" style="width: 80%"
                           placeholder="Please enter the ID of person you want to add as an Admin" name="remove_admin">
                    <input class="btn btn-primary btn-large" type="submit" value="Remove an Admin" style="margin-top: 3%;">
                </form>
            </div>
        </div>
        <h2><?= _("List of all Users:") ?></h2>
        <input class='form-control mb-4' id='tableSearch' type='text'
               placeholder='<?= _("Type something to search list items") ?>'>
        <table class="table">
            <thead>
            <tr>
                <th><?= _("ID") ?></th>
                <th><?= _("Firstname") ?></th>
                <th><?= _("Lastname") ?></th>
                <th><?= _("Email") ?></th>
                <th><?= _("Phone Number") ?></th>
                <th><?= _("Function") ?></th>
                <th><?= _("Localisation") ?></th>
            </tr>
            </thead>
            <tbody id="myTable">
            <?php

            for ($i = 0; $i < sizeof($results); $i++) {
                $firstName = $results[$i]['firstName'];
                $lastName = $results[$i]['lastName'];
                $email = $results[$i]['email'];
                $phone = $results[$i]['phoneNumber'];
                $idPerson = $results[$i]['idPerson'];
                $function = $results[$i]['function'];
                $localisation = $results[$i]['localisation'];


                echo "<tr>";
                echo "<td>" . $idPerson . "</td>";
                echo "<td>" . $firstName . "</td>";
                echo "<td>" . $lastName . "</td>";
                echo "<td>" . $email . "</td>";
                echo "<td>" . $phone . "</td>";
                echo "<td>" . $function . "</td>";
                echo "<td>" . $localisation . "</td>";
                echo "</tr>";
            }
            ?>
            </tbody>
        </table>
    </div>
</main>
<?php
require "footer.php";
?>
</body>
