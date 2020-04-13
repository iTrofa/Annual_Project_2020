<?php
require_once "DbManager.php";
$DbManager = new DbManager();
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['id'])){
    header('location: login.php');
    exit;
}
$q = $DbManager->getDb()->prepare("SELECT lang from Person WHERE idPerson = ?");
$q->execute([
   $_SESSION['id']
]);
$res = $q->fetchAll();
if($res[0]['lang'] != "en_US"){
    $_SESSION['lang'] = $res[0]['lang'];
}