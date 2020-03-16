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
      <script src="header.js"></script>
      <script src="footer.js"></script>
  </head>
  <body onload="checkFooter()">
    <?php
      require_once 'header.php';
     ?>
    <?php
    session_start();

    include('DbManager.php');
    $DbManager = new DbManager();
    $req =  $DbManager->getDb()->prepare('SELECT function FROM person WHERE idPerson = ?');
    $req->execute(array($_SESSION['id']));

    // lancement de la requête
    $res = $req->fetch();

    if($res['function'] === "admin" ){
        ?>
    <h1 style="text-align: center">History of all purchases:</h1>
    <div>
        <?php
        $req = $DbManager->getDb()->query('SELECT dateLog,idService FROM log');
        $res = $req->fetchAll();
        $req = $DbManager->getDb()->prepare('SELECT name,category FROM service where idService = :service ');
        foreach ($res as $param)
        {

            $req->execute([':service'=>$param['idService']]);
            $p = $req->fetch();
            ?> <p><?= $param['dateLog']?>, <?=$p['name']?>,  <?= $p['category'] ?></p><br>
        <?php
        }
      }else{
        ?>
        <h1 style="text-align: center">History of all purchases:</h1>
        <div>
            <?php
      $req = $DbManager->getDb()->prepare('SELECT idService,dateLog FROM log WHERE idPerson = ?');
      $req->execute(array($_SESSION['id']));
      $res = $req->fetchAll();
            $req = $DbManager->getDb()->prepare('SELECT name,category FROM service where idService = :service ');
            if(!empty($res)) {
         foreach ($res as $param) {
             $req->execute([':service' => $param['idService']]);
             $p = $req->fetch();
             ?> <p><?= $param['dateLog'] ?>, <?= $p['name'] ?>, <?= $p['category'] ?></p><br>
             <?php
         }
     }
      else{
          echo "<p style='text-align: center'>You didn't buy anything yet. <a href='services.php'>You should buy something </a></p>";
      }
    }
  ?>
    </div>
  </body>
  <?php 
    include('footer.php');
  ?>
</html>