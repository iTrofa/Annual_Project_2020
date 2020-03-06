<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="css/Affichage.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">

    <title>Historique des services</title>
    <script src="footer.js" defer></script>
  </head>
  <body onload="checkFooter()">
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
    while($function = $req->fetch()){
      $reponse[] = $function;
      if($function['function'] == "admin" ){
        $req = $db->prepare('SELECT dateInterv,name,category FROM log,service');
        $req->execute(array());
          while($admin = $req->fetch()){
            $reponse[] = $admin;
            echo $admin['dateInterv'] . ' ';
            echo $admin['name'] . ' ';
            echo $admin['category'] . ' ';
            ?> <br> <?php
          }  
      }else{


        
      $req = $db->prepare('SELECT idLog FROM log WHERE id_person = ?');
      $req->execute(array($_SESSION['id']));
      while($idLog = $req->fetch()){
        $reponse[] = $idLog;

        // lancement de la requête  
        $req = $db->prepare('SELECT dateInterv,service FROM log WHERE idLog = ?');
        $req->execute(array($idLog['idLog']));
        while($history = $req->fetch()){
          $reponse[] = $history;
          echo $history['dateInterv'] . ' ' ;
          echo $history['service'] . ' ';
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
   } 
  ?>
    </div>
  </body>
  <?php 
    include('footer.php');
  ?>
</html>