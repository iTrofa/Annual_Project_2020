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

<?php
if (!empty($_POST))
{
    $validator = new SignupValidator($_POST, $_FILES, true);
    $validator->validateEmptyInputsUpdate();
} else
{
    $res = $DbManager->query('select firstName, lastName, email, phoneNumber,localisation,profilePic ');
}
?>

<body onload="checkFooter()">
<?php
include('header.php');
?>
<main>
    <br>
    <div class="container">
        <!-- edit form column -->
        <div class="col-lg-12 text-lg-center">
            <h2><?= _("Edit Profile") ?></h2>
            <br>
            <br>
        </div>
        <div class="col-lg-8 push-lg-4 personal-info">
            <form method="post" role="form">
                <div class="form-group row">
                    <div class="col-lg-9">
                        <img src="<?= $res['profilePic'] ?>" alt="image not found" id="profilePic">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label"><?= _("First Name") ?>
                        <div class="col-lg-9">
                            <?php if ($res) : ?>
                                <input class="form-control" name="firstName" type="text"
                                       value="<?= $res['firstName'] ?>">
                            <?php else: ?>
                                <input class="form-control" name="firstName" type="text"
                                       value="<?= $_SESSION['firstName'] ?? '' ?>">
                            <?php endif; ?>
                        </div>
                    </label>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label"><?= _("Last Name") ?>
                        <div class="col-lg-9">
                            <?php if ($res) : ?>
                                <input class="form-control" name="lastName" type="text" value="<?= $res['lastName'] ?>">
                            <?php else: ?>
                                <input class="form-control" name="lastName" type="text"
                                       value="<?= $_SESSION['lastName'] ?? '' ?>">
                            <?php endif; ?>
                        </div>
                    </label>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label"><?= _("address") ?>
                        <div class="col-lg-9">
                            <?php if ($res) : ?>
                                <input class="form-control" name="localisation" type="text"
                                       value="<?= $res['localisation'] ?>">
                            <?php else: ?>
                                <input class="form-control" name="localisation" type="text"
                                       value="<?= $_SESSION['localisation'] ?? '' ?>">
                            <?php endif; ?>
                        </div>
                    </label>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label"><?= _("Email") ?>
                        <div class="col-lg-9">
                            <?php if ($res) : ?>
                                <input class="form-control" type="email" value="<?= $res['email'] ?>">
                            <?php else: ?>
                                <input class="form-control" name="email" type="email"
                                       value="<?= $_SESSION['email'] ?? '' ?>">
                            <?php endif; ?>
                            < /div>
                    </label>
                </div>
                <div class="form-group row">
                    <div class="col-lg-9">
                        <label class="col-lg-3 col-form-label form-control-label"><?= _("Password") ?>

                            <input class="form-control" name="password" type="password"
                                   value="">
                        </label>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label form-control-label"><?= _("Confirm password") ?>
                            <div class="col-lg-9">
                                <input class="form-control" name="rePassword" type="password"
                                       value="">
                            </div>
                        </label>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label form-control-label"><?= _("Telephone number") ?>
                            <div class="col-lg-9"
                            <label>
                                <?php if ($res): ?>
                                    <input class="form-control" name="phone" type="tel"
                                           value="<?= $res['phoneNumber'] ?>">
                                <?php else: ?>
                                    <input class="form-control" name="phone" type="tel"
                                           value="<?= $_SESSION['phoneNumber'] ?? '' ?>">
                                <?php endif; ?>
                            </label>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label"><?= _("address") ?>
                        <div class="col-lg-9">
                            <input class="form-control" name="localisation" type="text"
                                   value="">
                        </div>
                    </label>
                </div>
                <div class="form-group row">
                    <div class="col-lg-9">
                        <label class="col-lg-3 col-form-label form-control-label">
                            <input type="reset" class="btn btn-secondary" value="<?= _('Cancel') ?>">
                            <input type="button" class="btn btn-primary" value="<?= _('Save Changes') ?>">
                        </label>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <br><br>
</main>
<?php
include("footer.php");
?>
</body>
</html>


