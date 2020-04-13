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
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<link rel="stylesheet" href="css/main.css">
<link rel="stylesheet" href="css/stripe.css"/>
<title><?= _("Account - Flash Assistance")?></title>
<script src="header.js" defer></script>
<script src="footer.js" defer></script>
<style>

</style>
<body onload="checkFooter()">
<?php
include('header.php');
?>
<main>
    <br>
    <div class="container">
        <!-- edit form column -->
        <div class="col-lg-12 text-lg-center">
            <h2><?= _("Edit Profile")?></h2>
            <br>
            <br>
        </div>
        <div class="col-lg-8 push-lg-4 personal-info">
            <form role="form">
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label"><?=_("Nombre")?></label>
                    <div class="col-lg-9">
                        <input class="form-control" type="text" value="" />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label"><?=_("Email")?></label>
                    <div class="col-lg-9">
                        <input class="form-control" type="email" value="" />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label"><?=_("Password")?></label>
                    <div class="col-lg-9">
                        <input class="form-control" type="password" value="" />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label"><?=_("Confirm password")?></label>
                    <div class="col-lg-9">
                        <input class="form-control" type="password" value="" />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label"></label>
                    <div class="col-lg-9">
                        <input type="reset" class="btn btn-secondary" value="<?=_('Cancel')?>" />
                        <input type="button" class="btn btn-primary" value="<?=_('Save Changes')?>" />
                    </div>
                </div>
            </form>
        </div>
        <div class="col-lg-4 pull-lg-8 text-xs-center">
            <img src="//placehold.it/150" class="m-x-auto img-fluid img-circle" alt="avatar" />
            <h6 class="m-t-2"><?=_('Upload a different photo')?></h6>
            <label class="custom-file" style="display: inline-block; margin-bottom:20%">
                <input type="file" id="file" style="display: inline-block;padding: 0" class="custom-file-input"><span style="display: inline-block" class="custom-file-control"><?=_('Choose file')?></span>
            </label>
        </div>
    </div>
    <br><br>
</main>
<?php
include ("footer.php");
?>
</body>
</html>


