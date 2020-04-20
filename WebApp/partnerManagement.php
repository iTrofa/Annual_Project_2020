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
if (isset($_POST['add_job']) && isset($_POST['id_add_job'])) {
    $q = $DbManager->getDb()->prepare("UPDATE orders SET affected = ? WHERE idOrders = ?");
    $q->execute([
        $_POST['add_job'],
        $_POST['id_add_job']
    ]);
    if($q->rowCount() > 0) {
        $return['success'] = "The Worker was successfully affected to the Job!";
    }else{
        $return['success'] = 'Incorrect IDs please check for spaces in the ID';
    }
}
if (isset($_POST['remove_job']) && isset($_POST['id_remove_job'])) {
    $q = $DbManager->getDb()->prepare("UPDATE orders SET affected = NULL WHERE idOrders = ? && affected = ?");
    $q->execute([
        $_POST['id_remove_job'],
        $_POST['remove_job'],

    ]);
    if($q->rowCount() > 0) {
        $return['remove'] = "The Worker was successfully removed from the Job!";
    }else{
        $return['remove'] = "The Worker wasn't removed from the Job! Please the verify the IDs for spaces";
    }
}
?>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="images/logo_dark.png"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/main.css">
    <title>Partner Management - Flash Assistance</title>
    <script src="header.js"></script>
    <script src="footer.js"></script>
</head>
<body onload="checkFooter()">
<?php
require_once "header.php";
?>
<main>
    <?php
    $q = $DbManager->getDb()->prepare("SELECT * FROM person INNER JOIN orders on orders.affected != person.idPerson WHERE function != ''");
    $q->execute();
    $res = $q->fetchAll();

    $q = $DbManager->getDb()->prepare("SELECT idOrders, idPerson, service.name FROM orders LEFT JOIN service on orders.idService = service.idService WHERE affected is NULL && status='payed'");
    $q->execute();
    $affected = $q->fetchAll();

    $q = $DbManager->getDb()->prepare("SELECT * FROM person INNER JOIN orders on orders.affected = person.idPerson");
    $q->execute();
    $ActiveWorkers = $q->fetchAll();

    $q = $DbManager->getDb()->prepare("SELECT idOrders, idPerson, affected, service.name FROM orders LEFT JOIN service on orders.idService = service.idService WHERE affected is NOT NULL && status='payed'");
    $q->execute();
    $Activated = $q->fetchAll();

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
                    <h2>Add worker to Job</h2>
                    <input type="text" style="width: 80%"
                           placeholder="Please enter the ID of the worker you want to a Job" name="add_job">
                    <input type="text" style="width: 80%; margin-top: 3%"
                           placeholder="Please enter the ID of the Job you want to add the worker to" name="id_add_job">
                    <input class="btn btn-primary btn-large" type="submit" value="Add a Worker to a Job" style="margin-top: 3%">
                </form>
            </div>
            <div class="col-md-6">
                <form method="post" style="padding-top: 5%">
                    <h2>Remove worker from Job</h2>
                    <input type="text" style="width: 84%"
                           placeholder="Please enter the ID of worker you want to remove from a Job" name="remove_job">
                    <input type="text" style="width: 84%;margin-top: 3%"
                           placeholder="Please enter the ID of Job you want to remove the worker from" name="id_remove_job">
                    <input class="btn btn-primary btn-large" type="submit" value="Remove a Worker from a job" style="margin-top: 3%;">
                </form>
            </div>
        </div>

        <h2 style="padding-top: 5%"><?= _("List of all Available Workers:") ?></h2>
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

            for ($i = 0; $i < count($res); $i++) {
                $firstName = $res[$i]['firstName'];
                $lastName = $res[$i]['lastName'];
                $email = $res[$i]['email'];
                $phone = $res[$i]['phoneNumber'];
                $idPerson = $res[$i]['idPerson'];
                $function = $res[$i]['function'];
                $localisation = $res[$i]['localisation'];


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
        <h2 style="padding-top: 5%"><?= _("List of all Available Jobs:") ?></h2>
        <input class='form-control mb-4' id='tableSearch2' type='text'
               placeholder='<?= _("Type something to search list items") ?>'>
        <table class="table">
            <thead>
            <tr>
                <th><?=_("Order ID")?></th>
                <th><?=_("Client ID")?></th>
                <th><?=_("Service Requested")?></th>
            </tr>
            </thead>
            <tbody id="myTable2">
            <?php

            for ($i = 0; $i < count($affected); $i++) {
                $orders = $affected[$i]['idPerson'];
                $serviceName = $affected[$i]['name'];
                $idOrder = $affected[$i]['idOrders'];



                echo "<tr>";
                echo "<td>" . $idOrder . "</td>";
                echo "<td>" . $orders . "</td>";
                echo "<td>" . $serviceName . "</td>";


                echo "</tr>";
            }
            ?>
            </tbody>
        </table>

        <h2 style="padding-top: 5%"><?= _("List of all Active Workers:") ?></h2>
        <input class='form-control mb-4' id='tableSearch2' type='text'
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
            <tbody id="myTable2">
            <?php

            for ($i = 0; $i < count($ActiveWorkers); $i++) {
                $firstName = $ActiveWorkers[$i]['firstName'];
                $lastName = $ActiveWorkers[$i]['lastName'];
                $email = $ActiveWorkers[$i]['email'];
                $phone = $ActiveWorkers[$i]['phoneNumber'];
                $idPerson = $ActiveWorkers[$i]['idPerson'];
                $function = $ActiveWorkers[$i]['function'];
                $localisation = $ActiveWorkers[$i]['localisation'];


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

        <h2 style="padding-top: 5%"><?= _("List of all Active Jobs:") ?></h2>
        <input class='form-control mb-4' id='tableSearch2' type='text'
               placeholder='<?= _("Type something to search list items") ?>'>
        <table class="table">
            <thead>
            <tr>
                <th><?=_("Order ID")?></th>
                <th><?=_("Client ID")?></th>
                <th><?=_("Service Requested")?></th>
                <th><?=_("Worker ID")?></th>
            </tr>
            </thead>
            <tbody id="myTable2">
            <?php

            for ($i = 0; $i < count($Activated); $i++) {
                $orders = $Activated[$i]['idPerson'];
                $serviceName = $Activated[$i]['name'];
                $idOrder = $Activated[$i]['idOrders'];
                $affected = $Activated[$i]['affected'];



                echo "<tr>";
                echo "<td>" . $idOrder . "</td>";
                echo "<td>" . $orders . "</td>";
                echo "<td>" . $serviceName . "</td>";
                echo "<td>" . $affected . "</td>";
                echo "</tr>";
            }
            ?>
            </tbody>
        </table>
    </div>
</main>
<?php
require_once "footer.php";
?>
</body>
</html>