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
$q = $DbManager->query("SELECT orderoptions.options, orders.type, orders.idOrders FROM orderoptions LEFT JOIN orders on orders.idOrders = orderoptions.idOrders WHERE orders.idPerson = ? AND orderoptions.typeOptions = 'timeVariable' AND orders.status = 'payed'",
    [
        $_SESSION['id']
    ]);
$res = $q->fetchAll();

for($i=0; $i<count($res); $i++){
    switch ($res[$i]['type']) {
        case "Hour":
            $today = date('Y-m-d', time());
            $q = $DbManager->query("SELECT options FROM orderoptions WHERE idOrders = ? AND typeOptions = 'date'", [
                $res[$i]['idOrders']
            ]);
            $date = $q->fetchAll();
            if(!empty($date) && !empty($res[$i]['idOrders'])){
                if($today > $date[0]['options']){
                    $q = $DbManager->query("UPDATE orders SET affected = NULL WHERE idOrders = ?", [
                        $res[$i]['idOrders']
                    ]);
                    $q = $DbManager->query("UPDATE orders SET status = 'complete' WHERE idOrders = ?", [
                        $res[$i]['idOrders']
                    ]);
                }
            }
            break;
        case "Day":
            $today = date('Y-m-d', time());
            if(!empty($res[$i]['options'])) {
                if ($today > $res[$i]['options']) {
                    $q = $DbManager->query("UPDATE orders SET affected = NULL WHERE idOrders = ?", [
                        $res[$i]['idOrders']
                    ]);
                    $q = $DbManager->query("UPDATE orders SET status = 'complete' WHERE idOrders = ?", [
                        $res[$i]['idOrders']
                    ]);
                }
            }
            break;
        case "Month":
            $today2 = date('Y-m-d', time());
            if(!empty($res[$i]['options'])){
                if ($today2 > $res[$i]['options']) {
                    $q = $DbManager->query("UPDATE orders SET affected = NULL WHERE idOrders = ?", [
                        $res[$i]['idOrders']
                    ]);
                    $q = $DbManager->query("UPDATE orders SET status = 'complete' WHERE idOrders = ?", [
                        $res[$i]['idOrders']
                    ]);
                }
            }
            break;
        case "Year":
            $today3 = date('Y-m-d', time());
            if(!empty($res[$i]['options'])) {
                if ($today3 > $res[$i]['options']) {
                    $q = $DbManager->query("UPDATE orders SET affected = NULL WHERE idOrders = ?", [
                        $res[$i]['idOrders']
                    ]);
                    $q = $DbManager->query("UPDATE orders SET status = 'complete' WHERE idOrders = ?", [
                        $res[$i]['idOrders']
                    ]);
                }
            }
            break;
    }
}