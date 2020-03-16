<?php
require_once('vendor/autoload.php');
\Stripe\Stripe::setApiKey('sk_test_LgZBATKRdH41pyA60Bi3yxT600KSnzL8bW');
$token = $_POST['stripeToken'];
// This is a $20.00 charge in US Dollar.

// Create a Customer
$customer = \Stripe\Customer::create(array(
    "email" => $_SESSION['email'],
    "source" => $token,
));
// Save the customer id in your own database!

// Charge the Customer instead of the card
$charge = \Stripe\Charge::create(array(
    "amount" => 2000,
    "currency" => "eur",
    "customer" => $customer->id
));

// You can charge the customer later by using the customer id.
print_r($customer);
echo "<br><br>";
print_r($charge);

