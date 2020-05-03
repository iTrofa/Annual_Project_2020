<?php
require_once "session.php";

if(isset($_GET['lang'])){
 $DbManager = new DbManager();
    $q = $DbManager->getDb()->prepare("UPDATE person SET lang = ? WHERE idPerson = ?");
    $q->execute([
        $_GET['lang'],
        $_SESSION['id']
    ]);
}
$_SESSION['lang'] = $_GET['lang'];

$previousPage = $_SERVER['HTTP_REFERER'];
header("Location:  $previousPage");
exit;