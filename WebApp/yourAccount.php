<?php
require_once "session.php";
require_once "localization.php";
?>
<html>
<link href='https://fonts.googleapis.com/css?family=Playfair+Display&display=swap' rel='stylesheet'>
<link rel='stylesheet' href='css/services.css'>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" href="images/logo_dark.png"/>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
      integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
        crossorigin="anonymous"></script>
<link rel="stylesheet" href="css/main.css">
<link rel="stylesheet" href="css/stripe.css"/>
<title><?= _("Account - Flash Assistance") ?></title>
<script src="javascript/header.js" defer></script>
<script src="javascript/footer.js" defer></script>
<script src="javascript/profilePic.js" defer></script>

<?php

$res = $DbManager->query('select firstName, lastName, email, phoneNumber,localisation,profilePic FROM person WHERE idPerson = ?', [$_SESSION['id']]);
$_SESSION['res'] = $res->fetch();
$_SESSION['profilePic'] = $_SESSION['res']['profilePic'];

?>

<body onload="checkFooter()">
<?php
include('header.php');
?>
<main>
    <br>
    <h3><?php echo $_SESSION['valid']['request'] ?? '';
        echo $_SESSION['error']['request'] ?? '';
        if (isset($_SESSION['valid']['request']))
            unset($_SESSION['res']);
        unset($_SESSION['valid'], $_SESSION['error']) ?></h3>
    <div class="container">
        <!-- edit form column -->
        <div class="col-lg-12 text-lg-center">
            <h2><?= _("Edit Profile") ?></h2>
            <br>
            <br>
        </div>
        <div class="col-lg-8 push-lg-4 personal-info">
            <form method="post" action="checkYourAccount.php" role="form" enctype="multipart/form-data">
                <div class="form-group row">
                    <div id="input" class="col-lg-9">
                        <img src="<?= $_SESSION['profilePic'] ?>" alt="image not found" id="profilePic">
                    </div>
                </div>
                <div class="form-group row">
                    <label><?= _("First Name") ?>
                        <span class="error"><?= $_SESSION['error']['firstName'] ?? '' ?></span>
                        <?php if (isset($_SESSION['res'])) : ?>
                            <input class="form-control" name="firstName" type="text"
                                   value="<?= $_SESSION['res']['firstName'] ?>">
                        <?php else: ?>
                            <input class="form-control" name="firstName" type="text"
                                   value="<?= $_SESSION['valid']['firstName'] ?? '' ?>">
                        <?php endif; ?>
                    </label>
                </div>
                <div class="form-group row">
                    <label><?= _("Last Name") ?>
                        <span class="error"><?= $_SESSION['error']['lastName'] ?? '' ?></span>
                        <?php if (isset($_SESSION['res'])) : ?>
                            <input class="form-control" name="lastName" type="text"
                                   value="<?= $_SESSION['res']['lastName'] ?>">
                        <?php else: ?>
                            <input class="form-control" name="lastName" type="text"
                                   value="<?= $_SESSION['valid']['lastName'] ?? '' ?>">
                        <?php endif; ?>
                    </label>
                </div>
                <div class="form-group row">
                    <label><?= _("address") ?>
                        <?php if (isset($_SESSION['res'])) : ?>
                            <span class="error"><?= $_SESSION['error']['localisation'] ?? '' ?></span>
                            <input class="form-control" name="localisation" type="text"
                                   value="<?= $_SESSION['res']['localisation'] ?>">
                        <?php else: ?>
                            <input class="form-control" name="localisation" type="text"
                                   value="<?= $_SESSION['valid']['localisation'] ?? '' ?>">
                        <?php endif; ?>
                    </label>
                </div>
                <div class="form-group row">
                    <label><?= _("Email") ?>
                        <span class="error"><?= $_SESSION['error']['email'] ?? '' ?></span>
                        <?php if (isset($_SESSION['res'])) : ?>
                            <input class="form-control" name="email" type="email"
                                   value="<?= $_SESSION['res']['email'] ?>">
                        <?php else: ?>
                            <input class="form-control" name="email" type="email"
                                   value="<?= $_SESSION['valid']['email'] ?? '' ?>">
                        <?php
                        endif;
                        ?>
                    </label>
                </div>
                <div class="form-group row">
                    <label><?= _("Password") ?>
                        <span class="error"><?= $_SESSION['error']['password'] ?? '' ?></span>
                        <input class="form-control" style="margin-right: 10px" name="password" type="password"
                               value="">
                    </label>
                    <div class="form-group row">
                        <label>
                            <pre style="margin: 0px">   <?= _("Confirm password") ?> </pre>
                            <input class="form-control" style="margin-left: 30px" name="rePassword" type="password"
                                   value="">
                        </label>
                    </div>
                    <div class="form-group row">
                        <label><?= _("Telephone number") ?>
                            <label>
                                <?php if (isset($_SESSION['res'])): ?>
                                    <input class="form-control" name="phone" type="tel"
                                           value="<?= $_SESSION['res']['phoneNumber'] ?>">
                                <?php else: ?>
                                    <input class="form-control" name="phone" type="tel"
                                           value="<?= $_SESSION['valid']['phoneNumber'] ?? '' ?>">
                                <?php endif; ?>
                            </label>
                            <br>
                    </div>
                    <div class="form-group row">
                        <label style="margin-left: 50px">
                            <input type="reset" class="btn btn-secondary" value="<?= _('Cancel') ?>">
                            <input type="submit" class="btn btn-primary" value="<?= _('Save Changes') ?>">
                        </label>
                    </div>

                    <br><br>
</main>
<?php
unset($_SESSION['error'], $_SESSION['valid']);
include("footer.php");
?>
</body>
</html>


