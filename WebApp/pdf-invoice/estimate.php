<?php
require_once __DIR__. "/../session.php";
require_once __DIR__.'/lib/pdf-invoice/src/InvoicePrinter.php';
use Konekt\PdfInvoice\InvoicePrinter;

$db = new DbManager();
$q = $db->query("SELECT firstName,lastName,localisation from person WHERE idPerson = ?", [$_SESSION['id']]);
$datas = $q->fetchAll();
$q = $db->query("SELECT subscription.nameSub FROM person LEFT JOIN subscription on subscription.idSub = person.subscription WHERE idPerson = ?", [$_SESSION['id']]);
$sub = $q->fetchAll();
/* Adding Items in table */
$totalPrice = 0;
if (isset($sub[0]['nameSub'])) {
    switch ($sub[0]['nameSub']) {
        case "Basic":
            $nameSub = "Basic";
            $valueSub = 0.8;
            break;
        case "Professional":
            $nameSub = "Professional";
            $valueSub = 0.6;
            break;
        case "Enterprise" :
            $nameSub = "Enterprise";
            $valueSub = 0.4;
            break;
    }
}
$q = $db->query("SELECT * FROM service WHERE idService = ?", [$_GET['service']]);
$services = $q->fetchAll();

    $date = new DateTime('now');
    $date = $date->format('d-m-Y');
    $q = $db->getDb()->prepare('INSERT INTO estimate(idestimate, pdf, idService, status, price, idPerson, dateEstimate) VALUES (?, ?, ?, ?, ?, ?, STR_TO_DATE(?, "%d-%m-%Y"))');

    foreach ($datas as $service) {
        $discount = 0;
        if (isset($valueSub)) {
            $discount = $valueSub;
        }
    $invoice = new InvoicePrinter();
    /* Header Settings */
    $invoice->setLogo(__DIR__ . "/images/logo.png");
    $invoice->setColor("#AA3939");
    $invoice->setType("Sale Invoice");
    $invoice->setReference("INV-" . bin2hex(random_bytes(5)));


    $invoice->setDate(date(' D d M,Y', time()));

    $invoice->setFrom(['Flash Assistance', 'Flash Assistance', '242 Faubourg Saint Antoine', 'Paris 75016', 'France']);
    $invoice->setTo([$datas[0]['firstName'] . ' ' . $datas[0]['lastName'], $datas[0]['localisation'], 'France']);

    $invoice->addItem($services[0]['name'], $services[0]['description'], 1, $_GET['price'] * 0.21,
        $_GET['price'] - $_GET['price'] * 0.21 + $_GET['price'] * $discount, $_GET['price'] * $discount,
        $_GET['price']);
    /* Add totals */
    $invoice->addTotal('Total due', $_GET['price'], true);
    /* Set badge */
    $invoice->addBadge('Estimate');
    /* Add title */
    $invoice->addTitle('Important Notice');
    /* Add Paragraph */
    $invoice->addParagraph("The services can't be refunded");
    /* Set footer note */
    $invoice->setFooternote('Flash Assistance');
    /* Render */
    $name = 'estimates/';
    $name .= bin2hex(random_bytes(10));
    $name .= '.pdf';
    $invoice->render(__DIR__ . "/" . $name, 'F');
    $q->execute([$db::v4(), $name, $_GET['service'], NULL, $_GET['price'], $_SESSION['id'], $date]);
}
$location = 'Location: ../pdf-invoice/' . $name;
header($location);
exit();