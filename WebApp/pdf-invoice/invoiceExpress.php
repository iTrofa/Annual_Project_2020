<?php

require_once 'lib/pdf-invoice/src/InvoicePrinter.php';

use Konekt\PdfInvoice\InvoicePrinter;

$db = new DbManager();
$q = $db->query("SELECT idOrders,service.name,service.description,orders.price,firstName,lastName,localisation from orders join person on orders.idPerson = person.idPerson join
    service on orders.idService = service.idService
    where
      status ='express' and
      orders.idPerson = ?", [$_SESSION['id']]);
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
    $date = new DateTime('now');
    $date = $date->format('d-m-Y');
    $q = $db->query('update orders set dateOrder = STR_TO_DATE(?, "%d-%m-%Y") where idOrders = ?', [$date, $datas[0]['idOrders']]);
    $q = $db->getDb()->prepare('INSERT INTO bill(idBill, price, pdf, creationDate, idOrders) VALUES (?, ?, ?, STR_TO_DATE(?, "%d-%m-%Y"), ?)');

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

    $invoice->addItem($service['name'], $service['description'], 1, $service['price'] * 0.21,
        $service['price'] - $service['price'] * 0.21 + $service['price'] * $discount, $service['price'] * $discount,
        $service['price']);
    /* Add totals */
    $invoice->addTotal('Total due', $service['price'], true);
    /* Set badge */
    $invoice->addBadge('Invoice');
    /* Add title */
    $invoice->addTitle('Important Notice');
    /* Add Paragraph */
    $invoice->addParagraph("The services can't be refunded");
    /* Set footer note */
    $invoice->setFooternote('Flash Assistance');
    /* Render */
    $name = 'bills/';
    $name .= bin2hex(random_bytes(10));
    $name .= '.pdf';
    $invoice->render(__DIR__ . "/" . $name, 'F');
    $q->execute([$db::v4(), $service['price'], $name, $date, $service['idOrders']]);
}