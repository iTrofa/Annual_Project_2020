<?php
require_once 'autoload.php';
$DbManager = App::getDb();
if (session_status() === PHP_SESSION_NONE)
{
    session_start();
    if (isset($_SESSION['id']))
    {
        header('Location: main.php');
        exit;
    }
}
if (isset($_POST['english'])) {
    $_SESSION['lang'] = "en_US";
} else if (isset($_POST['french'])) {
    $_SESSION['lang'] = "fr_FR";
}



error_reporting(E_ALL | E_STRICT);

// define constants
define('PROJECT_DIR', realpath('./'));
define('LOCALE_DIR', PROJECT_DIR .'/Lang/locale');
define('DEFAULT_LOCALE', 'en_US');

require_once('Lang/gettext.inc');

$supported_locales = array('en_US', 'fr_FR');
$encoding = 'UTF-8';

$locale = (isset($_SESSION['lang']))? $_SESSION['lang'] : DEFAULT_LOCALE;

// gettext setup
T_setlocale(LC_MESSAGES, $locale);
// Set the text domain as 'messages'
$domain = 'main';
bindtextdomain($domain, LOCALE_DIR);
// bind_textdomain_codeset is supported only in PHP 4.2.0+
if (function_exists('bind_textdomain_codeset'))
    bind_textdomain_codeset($domain, $encoding);
textdomain($domain);

header("Content-type: text/html; charset=$encoding");

$return['error'] = '';
$return['valid'] = '';
if (!empty($_POST))
{
    $validator = new LoginValidator($_POST);
    $return = $validator->checkPassword();
}
?>
<!DOCTYPE html>
<html>
<head>
    <link href="http://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet"
          id="bootstrap-css">
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" defer></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js" defer></script>
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
    <title>Log In - Flash Assistance</title>
    <script src='http://production-assets.codepen.io/assets/common/stopExecutionOnTimeout-b2a7b3fe212eaa732349046d8416e00a9dec26eb7fd347590fbced3ab38af52e.js'
            defer>
    </script>
</head>
<body>
<header>
    <form method="post">
        <div style="margin-left: 7%">
            <input type="submit" name="english" style="display: inline-block; width: 15%" value="<?=_('Click here for English')?>"><img src="images/Countries/usa.png" style="width: 7%; height: 10%"><br>
            <input type="submit" name="french" style="display: inline-block; width: 15%" value="<?=_('Click here for French')?>"><img src="images/Countries/france.png" style="width: 7%; height: 10%">
        </div>
    </form>
</header>
    <div class="login">
        <h1><?= _('Login')?></h1>
        <span class="valid"> <?= $return['valid']?? '' ?> </span>
        <span class="error"> <?= $return['error'] ?? '' ?> </span>
        <form method="post">
            <label><?= _('Email:')?>
                <input type="email" name="email" placeholder="<?=_('Email')?>" required>
            </label>
            <label><?= _('Password:')?>
                <input type="password" name="password" placeholder="<?=_('Password')?>" required>
            </label>
            <button type="submit" id="btn" class="btn btn-primary btn-block btn-large"><?= _('Let me in.')?></button>
            <br>
            <a href="signup.php" style="color: midnightblue; text-transform: none"><h4><?=_('Sign Up')?></h4>
            </a>
            <?php
            $return['error'] = $return['error'] ?? '';
            $return['valid'] = $return['valid'] ?? '';
            if ($return['valid'] !== ''){
                header('Location: main.php');
                exit;
            }
            ?>
        </form>
    </div>
</body>
</html>








