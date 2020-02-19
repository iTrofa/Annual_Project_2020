<?php
require('config.php');

if (session_status() === PHP_SESSION_NONE)
{
    session_start();
}
/*
//CONNEXION
if (!empty($_POST['email']))
{
    $q = $db->prepare('SELECT password from person where email = :email ');
    $q->bindParam(':email', $_POST['email']);
    $q->execute();
    $res = $q->fetchall();
//$correctPassword = password_verify($_POST["password"], $res[0]['password']);
    if ($_POST["password"] != $res[0]['password'])
    {
        $correctPassword = 0;
    } else
    {
        $correctPassword = 1;
    }
    echo $correctPassword;
}*/
?>
<!DOCTYPE html>
<html lang="fr">
<head>

    <link href="http://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet"
          id="bootstrap-css">
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" defer></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js" defer></script>
    <!------ Include the above in your HEAD tag ---------->
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
    <title>Log In - Flash Assistance</title>
    <script src='http://production-assets.codepen.io/assets/common/stopExecutionOnTimeout-b2a7b3fe212eaa732349046d8416e00a9dec26eb7fd347590fbced3ab38af52e.js'
            defer>
    </script>

</head>
<body>
<div class="login">
    <h1>Login</h1>
    <form method="post">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" class="btn btn-primary btn-block btn-large">Let me in.</button>
        <?php /*
if (isset($_POST['password']) && !empty($_POST['password'])) {
    if ($correctPassword) {
        session_start();
        $_SESSION['password'] = $_POST['password'];
        header('location:main.php');
        exit;
    } else {*/ ?><!--
        <br>
        <h3>Password incorrect ! Try again.</h3>
       --><?php /*  }
} */ ?>
    </form>
</div>
</body>
</html>








