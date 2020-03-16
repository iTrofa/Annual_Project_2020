<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!--<link rel="stylesheet" href="css/Affichage.css">-->
    <link rel="stylesheet" type="text/css" href="css/main.css">

    <title>Historique des services</title>
    <script src="footer.js" defer></script>
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