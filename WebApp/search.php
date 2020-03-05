<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="css/Affichage.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <script src="footer.js"></script>
    
    <title>Historique des services</title>
  </head>
  <body>
    <?php
      require_once 'header.php';
     ?>

    <h1>Votre historique :</h1>
    <div>
      <?php 
    session_start();
    $connected=isset($_SESSION['id'])?true:false;
    include('config.php');
    
    $req = $db->prepare('SELECT function FROM person WHERE idPerson = ?');
    $req->execute(array($_SESSION['id']));
      // lancement de la requête  
    if("admin" == $req->fetch()){
      $req = $db->prepare('SELECT * FROM log');
      $req->execute(array());
    }else{


      
      $req = $db->prepare('SELECT idLog FROM log,person WHERE idPerson = ?');
      $req->execute(array($_SESSION['id']));
      while($idLog = $req->fetch()){
        $reponse[] = $idLog;

        // lancement de la requête  
        $req = $db->prepare('SELECT dateInterv,service FROM log WHERE idLog = ?');
        $req->execute(array($idLog['idLog']));
        while($history = $req->fetch()){
          $reponse[] = $history;
          echo $history['dateInterv'] . ' ' ;
          $req = $db->prepare('SELECT name, category FROM service WHERE idService = ?');
          $req->execute(array($history['service']));
          while($history = $req->fetch()){
            $reponse[] = $history;
            echo $history['name'] . ' ';
            echo $history['category'];
          }
        ?> <br> <?php
        }
      }
    }
    
  ?>
    </div>
    <?php 
      include('footer.php');
    ?>
  </body>
</html>