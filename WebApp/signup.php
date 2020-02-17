<!DOCTYPE html>
<html lang="fr">
<!-- <head>
    <script src='http://production-assets.codepen
    .io/assets/editor/live/console_runner-079c09a0e3b9ff743e39ee2d5637b9216b3545af0de366d4b9aad9dc87e26bfd.js'
            defer></script>
    <script src='http://production-assets.codepen
    .io/assets/editor/live/events_runner-73716630c22bbc8cff4bd0f07b135f00a0bdc5d14629260c3ec49e5606f98fdd.js'
            defer></script>
    <script src='http://production-assets.codepen
    .io/assets/editor/live/css_live_reload_init-2c0dc5167d60a5af3ee189d570b1835129687ea2a61bee3513dee3a50c115a77.js'
            defer></script>
    <meta charset='UTF-8'>
    <meta name="robots" content="noindex">
    <link rel="shortcut icon" type="image/x-icon" href="images/logo_dark.png"/>
    <link rel="mask-icon" type=""
          href="//production-assets.codepen.io/assets/favicon/logo-pin-f2d2b6d2c61838f7e76325261b7195c27224080bc099486ddd6dccb469b8e8e6.svg"
          color="#111"/>
    <link rel="canonical" href="https://codepen.io/frytyler/pen/EGdtg"/>

    <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css'>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js' defer></script>
    <link rel="stylesheet" href="css/login.css" class="cp-pen-styles">
    <title>Signup - Flash Assistance</title>
    <script src='http://production-assets.codepen.io/assets/common/stopExecutionOnTimeout-b2a7b3fe212eaa732349046d8416e00a9dec26eb7fd347590fbced3ab38af52e.js'
            defer>
    </script>

</head> -->
<body>
<?php

require_once 'InputValidator.php';

if (!empty($_POST))
{
    $validate = new InputValidator($_POST);

    $validate->validateEmptyInputs();

}
?>
        <h3><?php echo $_SESSION['valid']['request']  ?? '';
                  echo $_SESSION['error']['request'] ?? '';
                  unset($_SESSION['valid'],$_SESSION['error'])?></h3>
            <form action="" method="post">
                <label>first name
                    <input type="text" name="firstName" value="<?= $_SESSION['valid']['firstName'] ?? '' ?>" >
                </label>
                <div class="error"><?= $_SESSION['error']['firstName'] ?? '' ?></div>
                <br>
                <label>last name
                    <input type="text" name="lastName" value="<?= $_SESSION['valid']['lastName'] ?? '' ?>" >
                </label>
                <div class="error"><?= $_SESSION['error']['lastName'] ?? '' ?></div>
                <br>
                <label>email
                    <input type="text" name="email" value="<?= $_SESSION['valid']['email'] ?? '' ?>" >
                </label>
                <div class="error"><?= $_SESSION['error']['email'] ?? '' ?></div>
                <br>
                <label>phone number
                    <input type="text" name="phone" value="<?= $_SESSION['valid']['phone'] ?? '' ?>" >
                </label>
                <div class="error"><?= $_SESSION['error']['phone'] ?? '' ?></div>
                <br>
                <label> password
                    <input type="password" name="password" >
                </label>
                <div class="error"><?= $_SESSION['error']['password'] ?? '' ?></div>
                <br>
                <label> retype password
                    <br>
                    <input type="password" name="rePassword" >
                </label><br>
                <button type="submit" class="btn btn-primary btn-block btn-large">Signup</button>
                <br>
            </form>
<?php
unset($_SESSION['error'], $_SESSION['valid']);
?>
</body>
</html>
