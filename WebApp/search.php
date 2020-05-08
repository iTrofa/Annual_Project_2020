<?php
require_once 'session.php';
require_once "localization.php";
?>
<!DOCTYPE html>
<html lang="en">
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
      <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>-->
      <link rel="stylesheet" href="css/main.css">
      <title>Services History</title>
      <script src="javascript/header.js"></script>
      <script src="javascript/footer.js"></script>
  </head>
  <body onload="checkFooter()">
    <?php
      require_once 'header.php';
     ?>
    <?php
    $DbManager = App::getDb();
    $q =$DbManager->getDb()->prepare("SELECT admin FROM Person Where idPerson = ?");
    $q->execute([
        $_SESSION['id']
    ]);
    $res = $q->fetchAll();
    if($res[0]['admin']){
        ?>
    <h1 style="text-align: center"><?= _("History of all purchases:")?></h1>
        <?php
        $req = $DbManager->query("SELECT orders.idOrders, status, orders.price, dateOrder, service.name, bill.pdf FROM orders
    LEFT JOIN service on service.idService = Orders.idService 
    LEFT JOIN bill ON bill.idOrders = orders.idOrders WHERE status = 'payed' or status ='complete' ORDER BY dateOrder desc");
        $req->execute();
        $res = $req->fetchAll();
        if(!empty($res)){
            ?>
            <input class='form-control mb-4' id='tableSearch' type='text'
                   placeholder='<?= _("Type something to search list items") ?>'>
            <table class="table">
                <thead>
                <tr>
                    <th><?= _("ID") ?></th>
                    <th><?= _("PDF") ?></th>
                    <th><?= _("Status") ?></th>
                    <th><?= _("Price") ?></th>
                    <th><?= _("Date") ?></th>
                    <th><?= _("Service Name") ?></th>

                </tr>
                </thead>
                <tbody id="myTable">
                <?php

                for ($i = 0; $i < count($res); $i++) {
                    $id = $res[$i]['idOrders'];
                    $pdf = "pdf-invoice/".$res[$i]['pdf'];
                    $status = $res[$i]['status'];
                    $orderPrice = $res[$i]['price']."€";
                    $dateOrder = $res[$i]['dateOrder'];
                    $serviceName = $res[$i]['name'];


                    echo "<tr>";
                    echo "<td>" . $id . "</td>";
                    if ($pdf != "pdf-invoice/") {
                        echo "<td><a href=" . $pdf . ">PDF</a></td>";
                    }else{
                        echo "<td>NO PDF</td>";
                    }
                    echo "<td>" . $status . "</td>";
                    echo "<td>" . $orderPrice . "</td>";
                    echo "<td>" . $dateOrder . "</td>";
                    echo "<td>" . $serviceName . "</td>";
                    echo "</tr>";
                }
                ?>
                </tbody>
            </table>
      <?php
      }else {
      }
      }else{
        ?>
        <h1 style="text-align: center"><?=_("History of your purchases:")?></h1>
            <?php
      $req = $DbManager->query("SELECT orders.idOrders, status, orders.price, dateOrder, service.name, bill.pdf FROM orders LEFT JOIN service on service.idService = Orders.idService LEFT JOIN bill ON bill.idOrders = orders.idOrders WHERE idPerson = ? and status = 'payed' or status ='complete' ORDER BY dateOrder desc", [$_SESSION['id']]);
      $res = $req->fetchAll();
            if(!empty($res)) {
?>
            <input class='form-control mb-4' id='tableSearch' type='text'
                   placeholder='<?= _("Type something to search list items") ?>'>
            <table class="table">
                <thead>
                <tr>
                    <th><?= _("ID") ?></th>
                    <th><?= _("PDF") ?></th>
                    <th><?= _("Status") ?></th>
                    <th><?= _("Price") ?></th>
                    <th><?= _("Date") ?></th>
                    <th><?= _("Service Name") ?></th>

                </tr>
                </thead>
                <tbody id="myTable">
                <?php

                for ($i = 0; $i < count($res); $i++) {
                    $id = $res[$i]['idOrders'];
                    $pdf = "pdf-invoice/".$res[$i]['pdf'];
                    $status = $res[$i]['status'];
                    $orderPrice = $res[$i]['price']."€";
                    $dateOrder = $res[$i]['dateOrder'];
                    $serviceName = $res[$i]['name'];


                    echo "<tr>";
                    echo "<td>" . $id . "</td>";
                    if ($pdf == "pdf-invoice/") {
                        echo "<td><a href=" . $pdf . ">PDF</a></td>";
                    }else{
                        echo "<td>NO PDF</td>";
                    }
                    echo "<td>" . $status . "</td>";
                    echo "<td>" . $orderPrice . "</td>";
                    echo "<td>" . $dateOrder . "</td>";
                    echo "<td>" . $serviceName . "</td>";
                    echo "</tr>";
                }
                ?>
                </tbody>
            </table>
            <?php

     }else{
          $firstP = _("You haven't bought anything yet");
          $secondP = _("Perhaps you should buy something");
          echo "<p style='text-align: center'>$firstP<a href='services.php'> $secondP;) </a></p>";
      }
    }
  ?>
  </body>
  <?php 
    include'footer.php';
  ?>
</html>