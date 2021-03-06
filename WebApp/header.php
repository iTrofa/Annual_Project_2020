<?php
require_once "session.php";
require_once "localization.php";

$q = $DbManager->query("SELECT admin FROM person Where idPerson = ?",
    [
        $_SESSION['id']
    ]);
$res = $q->fetchAll();
?>
<header id="header">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary2">
        <a class="navbar-brand" href="/Annual_Project_2020/WebApp/main.php">Flash Assistance</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor02"
                aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarColor02">
            <ul class="navbar-nav mr-auto">
                <div class="dropdown">
                    <button style="background-color: orange" class="btn btn_header dropdown-toggle" type="button"
                            data-toggle="dropdown"><?= _("Account") ?>
                        <span class="caret"></span></button>
                    <ul class="dropdown-menu" style="background-color: orange">
                        <li><a class="nav-link" href="/Annual_Project_2020/WebApp/yourAccount.php"><?= _("Your Account") ?></a></li>
                        <?php
                        if ($res[0]['admin']) {
                            ?>
                            <li><a class="nav-link" href="/Annual_Project_2020/WebApp/addServices.php"><?= _("Add a Service") ?></a></li>
                            <?php
                        }
                        ?>
                        <?php
                        if ($res[0]['admin']) {
                            ?>
                            <li><a class="nav-link" href="/Annual_Project_2020/WebApp/addWebGL.php"><?= _("Add Demo WebGL") ?></a></li>
                            <?php
                        }
                        ?>
                        <?php
                        if ($res[0]['admin']) {
                            ?>
                            <li><a class="nav-link" href="/Annual_Project_2020/WebApp/clientManagement.php"><?= _("Client Management") ?></a></li>
                            <?php
                        }
                        ?>
                        <?php
                        if ($res[0]['admin']) {
                            ?>
                            <li><a class="nav-link" href="/Annual_Project_2020/WebApp/partnerManagement.php"><?= _("Partner Management") ?></a></li>
                            <?php
                        }
                        ?>
                        <?php
                        if ($res[0]['admin']) {
                            ?>
                            <li><a class="nav-link" href="/Annual_Project_2020/WebApp/updateSubscription.php"><?= _("Update Subscription") ?></a>
                            </li>
                            <?php
                        }
                        ?>
                        <li><a class="nav-link" href="/Annual_Project_2020/WebApp/logout.php"><?= _("Log Out") ?></a></li>
                    </ul>


                </div>
                <li class="nav-item">
                    <a class="nav-link" href="/Annual_Project_2020/WebApp/services.php"><?= _("Services") ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/Annual_Project_2020/WebApp/subscription.php"> <?= _("Subscriptions") ?> </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/Annual_Project_2020/WebApp/search.php"> <?= _("History") ?> </a>
                </li>
            </ul>
            <form class="form-inline">
                <?php
                $q = $DbManager->query("SELECT idOrders FROM orders WHERE status = 'active' && idPerson = ?",
                    [
                        $_SESSION['id']
                    ]);
                $res = $q->fetchAll();
                $link = "/Annual_Project_2020/WebApp/payment/paymentCart.php?";
                for($i = 0, $iMax = count($res); $i< $iMax; $i++){
                    if ($i > 0)
                        $link = $link . "&";
                    $link = $link . "cart" . $i . "=" . $res[$i]['idOrders'];
                }
                if (count($res) > 0) { ?>
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item"><a class="nav-link" style="color: red; font-weight: bold"
                                                href="<?= $link ?>"><?= _("Check Your Cart") ?></a>
                        </li>
                    </ul>
                <?php } ?>
            </form>
        </div>
    </nav>

</header>




