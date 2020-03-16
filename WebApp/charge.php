<?php

ini_set('error_log',1);
ini_set('display_errors',1);
use Stripe\Charge;
use Stripe\Customer;
use Stripe\Stripe;

session_start();
require_once('vendor/autoload.php');
Stripe::setApiKey('sk_test_LgZBATKRdH41pyA60Bi3yxT600KSnzL8bW');
$token = $_POST['stripeToken'];
// This is a $20.00 charge in US Dollar.

// Create a Customer
$customer = Customer::create(array(
    "email" => $_SESSION['email'],
    "source" => $token,
));
// Save the customer id in your own database!

// Charge the Customer instead of the card
$charge = Charge::create(array(
    "amount" => 2000,
    "currency" => "eur",
    "customer" => $customer->id
));

// You can charge the customer later by using the customer id.
header('Location: stripeAPI.php?return=your%20payment%20was%20processed%20successfully.');