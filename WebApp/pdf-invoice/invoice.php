<?php
require_once 'lib/pdf-invoice/src/InvoicePrinter.php';

use Konekt\PdfInvoice\InvoicePrinter;

session_start();

$db = new DbManager();
$q = $db->query("SELECT idOrders,service.name,service.description,service.price,firstName,lastName,localisation from orders join person on orders.idPerson = person.idPerson join
    service on orders.idService = service.idService
    where
      status ='active' and
      orders.idPerson = ?", [$_SESSION['id']]);
$datas = $q->fetchAll();

/* Adding Items in table */
$totalPrice = 0;

$date = new DateTime('now');
$date = $date->format('d-m-Y');


$q = $db->query('update orders set status = ? , dateOrder = STR_TO_DATE(?, "%d-%m-%Y") where idOrders = ? ',
    [$datas[0]['idOrders']]);

foreach ($datas as $service)
{

    $invoice = new InvoicePrinter();
    /* Header Settings */
    $invoice->setLogo("images/logo.png");
    $invoice->setColor("#AA3939");
    $invoice->setType("Sale Invoice");
    $invoice->setReference("INV-" . random_bytes(8));


    $invoice->setDate(date(' D d M,Y',time()));

    $invoice->setFrom(['Flash Assistance', 'Flash Assistance', '242 Faubourg Saint Antoine', 'Paris 75016', 'France']);
    $invoice->setTo([$datas[0]['firstName']. ' ' . $datas[0]['lastName'],$datas[0]['localisation'], 'France']);

    $invoice->addItem($service['name'], $service['description'], 1, 20,
        $service['price'], 0,
        $service['price']);
    /* Add totals */
    $invoice->addTotal('Total due',$service['price'],true);
    /* Set badge */
    $invoice->addBadge('Invoice');
    /* Add title */
    $invoice->addTitle('Important Notice');
    /* Add Paragraph */
    $invoice->addParagraph("The services can't be refound");
    /* Set footer note */
    $invoice->setFooternote('Flash Assistance');
    /* Render */
    $name = 'bills/';
    $name .= bin2hex(random_bytes(10));
    $name .='.pdf';
    $invoice->render($name,'F');
    $q->execute([$name,$date,$service['idOrders']]);
}