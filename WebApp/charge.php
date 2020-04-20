<?php
require_once "DbManager.php";
ini_set('error_log',1);
ini_set('display_errors',1);
use Stripe\Charge;
use Stripe\Customer;
use Stripe\Stripe;

session_start();
$DbManager = new DbManager();
$q = $DbManager->getDb()->prepare("SELECT subscription, nameSub FROM person LEFT JOIN subscription on person.subscription = subscription.idSub  WHERE idPerson = ?");
$q->execute([
    $_SESSION['id']
]);
$Sub = $q->fetchAll();
$nameSub = $Sub[0]['nameSub'];
switch ($nameSub){
    case "Basic":
        $valueSub = 0.8;
        break;
    case "Professional":
        $valueSub = 0.6;
        break;
    case "Enterprise" :
        $valueSub = 0.4;
        break;
}
if(isset($valueSub)){
    $finalprice =  $_SESSION['price'] * $valueSub * 100;
}else $finalprice = $_SESSION['price'] * 100;
require_once('vendor/autoload.php');
Stripe::setApiKey('sk_test_LgZBATKRdH41pyA60Bi3yxT600KSnzL8bW');
$token = $_POST['stripeToken'];

// Create a Customer
$customer = Customer::create(array(
    "email" => $_SESSION['email'],
    "source" => $token,
));
// Save the customer id in your own database!

// Charge the Customer instead of the card
$charge = Charge::create(array(
    "amount" => $finalprice,
    "currency" => "eur",
    "customer" => $customer->id
));
if(isset($_GET['express']) && $_GET['express'] == true ){
    $q = $DbManager->getDb()->prepare("UPDATE Orders SET status = 'payed' WHERE status = 'express'");
    $q->execute();
}else if(isset($_GET['sub'])){
    $old_date = date('Y-m-d');
    $next_due_date = date('Y-m-d', strtotime($old_date. ' +30 days'));
    echo $next_due_date;
    $q = $DbManager->getDb()->prepare("UPDATE Person SET subscription = ?, endSub = ? WHERE idPerson = ?");
    $q->execute([
        $_GET['sub'],
        $next_due_date,
        $_SESSION['id']
    ]);
}else{
    $q = $DbManager->getDb()->prepare("UPDATE Orders SET status = 'payed' WHERE status = 'active'");
    $q->execute();
}
// You can charge the customer later by using the customer id.
header('Location: stripeAPI.php?return=your%20payment%20was%20processed%20successfully.');
exit();