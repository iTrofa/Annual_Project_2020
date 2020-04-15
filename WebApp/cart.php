<?php
require_once "session.php";
$DbManager = App::getDb();


$q = $DbManager->query("SELECT * from service WHERE idService = :idService",
[':idService'=> $_GET['service']]);
$chosenService = $q->fetchAll();

function getDates($duration, $option){
    if(date('N', time()) == $option){
        $j = 0;
    }else {
        for ($i = 1; $i < 8; $i += 1) {
            if (date('N', time() + ($i * 24 * 60 * 60)) == $option) {
                $j = $i;
                break;
            }
        }
    }
    $count = 0;
    for ($i = $j; $i<$duration; $i+=7){
        $count+=1;
    }
    return $count;
}



switch ($_GET['package']){
    case "Hour(s)":
        $uuid = $DbManager::v4();
        $price = $_GET['hour'] * $chosenService[0]['price'] * 1/8;
        $DbManager->query('INSERT INTO orders(idOrders, type, price, status, idPerson, idService) VALUES(?, ?, ?, ?, ?, ?)',
            [
                $uuid,
                substr($_GET['package'], 0, -3),
                $price,
                "active",
                $_SESSION['id'],
                $_GET['service']
        ]);
        $q = $DbManager->query('INSERT INTO orderoptions(idOrderOption, idOrders, typeOptions, options) VALUES (?, ?, ?, ?)',
            [
           $DbManager::v4(),
           $uuid,
           'date',
           $_GET['date']
        ]);
        break;
    case "Day(s)":
        $uuid = $DbManager::v4();
        $week1 = $_GET['date1'];
        $week2 = $_GET['date2'];
        $week3 = $_GET['date3'];
        $week4 = $_GET['date4'];
        $week5 = $_GET['date5'];
        $week6 = $_GET['date6'];
        $week7 = $_GET['date7'];
        if($_GET['day'] <= 7) {
            $price = $_GET['hour'] * $chosenService[0]['price'] * 1 / 8;
            $options = 0;
        }else{
            $price = $_GET['day'] * $_GET['hour'] * $chosenService[0]['price'] * 1/8;
        }
        if($week1 === 'on') {
            if($_GET['day'] <= 7) {
                $options++;
            }
            $DbManager->query('INSERT INTO orderoptions(idOrderOption, idOrders, typeOptions, options) VALUES (?, ?, ?, ?)',
            [
                $DbManager::v4(),
                $uuid,
                'week1',
                $week1
            ]);
        }
        if($week2 === 'on') {
            if($_GET['day'] <= 7) {
                $options++;
            }
            $DbManager->query('INSERT INTO orderoptions(idOrderOption, idOrders, typeOptions, options) VALUES (?, ?, ?, ?)',
                [
                $DbManager::v4(),
                $uuid,
                'week2',
                $week2
            ]);
        }
        if ($week3 === 'on') {
            if($_GET['day'] <= 7) {
                $options++;
            }
            $DbManager->query('INSERT INTO orderoptions(idOrderOption, idOrders, typeOptions, options) VALUES (?, ?, ?, ?)',
                [
                $DbManager::v4(),
                $uuid,
                'week3',
                $week3
            ]);
        }
        if($week4 === 'on') {
            if($_GET['day'] <= 7) {
                $options++;
            }
            $DbManager->query('INSERT INTO orderoptions(idOrderOption, idOrders, typeOptions, options) VALUES (?, ?, ?, ?)',
                [
                $DbManager::v4(),
                $uuid,
                'week4',
                $week4
            ]);
        }
        if($week5 === 'on') {
            if($_GET['day'] <= 7) {
                $options++;
            }
            $DbManager->query('INSERT INTO orderoptions(idOrderOption, idOrders, typeOptions, options) VALUES (?, ?, ?, ?)',
                [
                $DbManager::v4(),
                $uuid,
                'week5',
                $week5
            ]);
        }
        if($week6 === 'on') {
            if($_GET['day'] <= 7) {
                $options++;
            }
            $DbManager->query('INSERT INTO orderoptions(idOrderOption, idOrders, typeOptions, options) VALUES (?, ?, ?, ?)',
                [
                $DbManager::v4(),
                $uuid,
                'week6',
                $week6
            ]);
        }
        if($week7 === 'on') {
            if($_GET['day'] <= 7) {
                $options++;
            }
            $DbManager->query('INSERT INTO orderoptions(idOrderOption, idOrders, typeOptions, options) VALUES (?, ?, ?, ?)',
                [
                $DbManager::v4(),
                $uuid,
                'week7',
                $week7
            ]);
        }
        if($_GET['day'] <= 7) {
            $price *= $options;
        }
        $DbManager->query('INSERT INTO orders(idOrders, type, price, status, idPerson, idService) VALUES(?, ?, ?, ?, ?, ?)',
            [
            $uuid,
            substr($_GET['package'], 0, -3),
            $price,
            'active',
            $_SESSION['id'],
            $_GET['service']
        ]);
        break;
    case 'Month(s)':
        $uuid = $DbManager::v4();

        $month1 = $_GET['date1'];
        $month2 = $_GET['date2'];
        $month3 = $_GET['date3'];
        $month4 = $_GET['date4'];
        $month5 = $_GET['date5'];
        $month6 = $_GET['date6'];
        $month7 = $_GET['date7'];

        $price = $_GET['hour'] * $chosenService[0]['price'] * 1 / 8;
        $options = 0;

        if($month1 === 'on') {
            $options += getDates(31*$_GET['day'], 1);
            $DbManager->query('INSERT INTO orderoptions(idOrderOption, idOrders, typeOptions, options) VALUES (?, ?, ?, ?)',
                [
                $DbManager::v4(),
                $uuid,
                'month1',
                $month1
            ]);
        }
        if($month2 === 'on') {
            $options += getDates(31*$_GET['day'], 2);
            $q = $DbManager->query('INSERT INTO orderoptions(idOrderOption, idOrders, typeOptions, options) VALUES (?, ?, ?, ?)',
                [
                $DbManager::v4(),
                $uuid,
                'month2',
                $month2
            ]);
        }
        if($month3 === 'on') {
            $options += getDates(31*$_GET['day'], 3);
            $q = $DbManager->query('INSERT INTO orderoptions(idOrderOption, idOrders, typeOptions, options) VALUES (?, ?, ?, ?)',
            [
                $DbManager::v4(),
                $uuid,
                'month3',
                $month3
            ]);
        }
        if($month4 === 'on') {
            $options += getDates(31*$_GET['day'], 4);
            $q = $DbManager->query('INSERT INTO orderoptions(idOrderOption, idOrders, typeOptions, options) VALUES (?, ?, ?, ?)',
                [
                $DbManager::v4(),
                $uuid,
                'month4',
                $month4
            ]);
        }
        if($month5 === 'on') {
            $options += getDates(31*$_GET['day'], 5);
            $q = $DbManager->query('INSERT INTO orderoptions(idOrderOption, idOrders, typeOptions, options) VALUES (?, ?, ?, ?)',
                [
                $DbManager::v4(),
                $uuid,
                'month5',
                $month5
            ]);
        }
        if($month6 === 'on') {
            $options += getDates(31*$_GET['day'], 6);
            $q = $DbManager->query('INSERT INTO orderoptions(idOrderOption, idOrders, typeOptions, options) VALUES (?, ?, ?, ?)',
                [
                $DbManager::v4(),
                $uuid,
                'month6',
                $month6
            ]);
        }
        if($month7 === 'on') {
            $options += getDates(31*$_GET['day'], 7);
            $DbManager->query('INSERT INTO orderoptions(idOrderOption, idOrders, typeOptions, options) VALUES (?, ?, ?, ?)',
                [
                $DbManager::v4(),
                $uuid,
                'month7',
                $month7
            ]);
        }

        $DbManager->query("INSERT INTO orders(idOrders, type, price, status, idPerson, idService) VALUES(?, ?, ?, ?, ?, ?)",
        [
            $uuid,
            substr($_GET['package'], 0, -3),
            $price,
            "active",
            $_SESSION['id'],
            $_GET['service']
        ]);

        break;

    case 'Year(s)':
        $uuid = $DbManager::v4();

        $year1 = $_GET['date1'];
        $year2 = $_GET['date2'];
        $year3 = $_GET['date3'];
        $year4 = $_GET['date4'];
        $year5 = $_GET['date5'];
        $year6 = $_GET['date6'];
        $year7 = $_GET['date7'];

        $price = $_GET['hour'] * $chosenService[0]['price'] * 1 / 8;
        $options = 0;

        if($year1 === 'on') {
            $options += getDates(31*12*$_GET['day'], 1);
            $DbManager->query('INSERT INTO orderoptions(idOrderOption, idOrders, typeOptions, options) VALUES (?, ?, ?, ?)',
                [
                $DbManager::v4(),
                $uuid,
                'year1',
                $year1
            ]);
        }
        if($year2 === 'on') {
            $options += getDates(31*12*$_GET['day'], 2);
            $DbManager->query('INSERT INTO orderoptions(idOrderOption, idOrders, typeOptions, options) VALUES (?, ?, ?, ?)',
            [
                $DbManager::v4(),
                $uuid,
                'year2',
                $year2
            ]);
        }
        if($year3 === 'on') {
            $options += getDates(31*12*$_GET['day'], 3);
            $DbManager->query('INSERT INTO orderoptions(idOrderOption, idOrders, typeOptions, options) VALUES (?, ?, ?, ?)',
            [
                $DbManager::v4(),
                $uuid,
                'year3',
                $year3
            ]);
        }
        if($year4 === 'on') {
            $options += getDates(31*12*$_GET['day'], 4);
            $DbManager->query('INSERT INTO orderoptions(idOrderOption, idOrders, typeOptions, options) VALUES (?, ?, ?, ?)',
                [
                $DbManager::v4(),
                $uuid,
                'year4',
                $year4
            ]);
        }
        if($year5 === 'on') {
            $options += getDates(31*12*$_GET['day'], 5);
            $DbManager->query('INSERT INTO orderoptions(idOrderOption, idOrders, typeOptions, options) VALUES (?, ?, ?, ?)',
                [
                $DbManager::v4(),
                $uuid,
                'year5',
                $year5
            ]);
        }
        if($year6 === 'on') {
            $options += getDates(31*12*$_GET['day'], 6);
            $q = $DbManager->query('INSERT INTO orderoptions(idOrderOption, idOrders, typeOptions, options) VALUES (?, ?, ?, ?)',
            [
                $DbManager::v4(),
                $uuid,
                'year6',
                $year6
            ]);
        }
        if($year7 === 'on') {
            $options += getDates(31*12*$_GET['day'], 7);
            $q = $DbManager->query('INSERT INTO orderoptions(idOrderOption, idOrders, typeOptions, options) VALUES (?, ?, ?, ?)',
                [
                $DbManager::v4(),
                $uuid,
                'year7',
                $year7
            ]);
        }

        $price*=$options;

        $q = $DbManager->query('INSERT INTO orders(idOrders, type, price, status, idPerson, idService) VALUES(?, ?, ?, ?, ?, ?)',
            [
            $uuid,
            substr($_GET['package'], 0, -3),
            $price,
            'active',
            $_SESSION['id'],
            $_GET['service']
        ]);
        break;
}

header('Location: services.php?AddtoCart=success');
exit();