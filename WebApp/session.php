<?php
require_once 'autoload.php';

$DbManager = App::getDb();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['id'])){
    header('location: login.php');
    exit;
}
$q = $DbManager->query('SELECT lang from person WHERE idPerson = ?',[ $_SESSION['id'] ]);
$res = $q->fetchAll();
if($res[0]['lang'] !== 'en_US'){
    $_SESSION['lang'] = $res[0]['lang'];
}
$q = $DbManager->getDb()->prepare("SELECT endSub from Person WHERE idPerson = ?");
$q->execute([
   $_SESSION['id']
]);
$res = $q->fetchAll();
$endSub = $res[0]['endSub'];
$today = date('Y-m-d', time());
if($today > $endSub){
    $q = $DbManager->getDb()->prepare("Update Person SET subscription = NULL, endSub = NULL WHERE idPerson = ?");
    $q->execute([
       $_SESSION['id']
    ]);
}
