<?php
require_once "DbManager.php";
ini_set('error_log',1);
ini_set('display_errors',1);
use Stripe\Charge;
use Stripe\Customer;
use Stripe\Stripe;

session_start();
var_dump($_SESSION);
$finalprice = $_SESSION['price'] * 100;
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
$DbManager = new DbManager();
$q =  $DbManager->getDb()->prepare("UPDATE Orders SET status = 'payed' WHERE status = 'active'");
$q->execute();

// You can charge the customer later by using the customer id.
header('Location: stripeAPI.php?return=your%20payment%20was%20processed%20successfully.');
exit();