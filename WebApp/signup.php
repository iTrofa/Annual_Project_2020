<?php
if (session_status() === PHP_SESSION_NONE)
{
    session_start();
    if (isset($_SESSION['id']))
    {
        header('Location: main.php');
    }
}

require_once 'SignupValidator.php';

if (!empty($_POST))
{
    $validate = new SignupValidator($_POST);

    $validate->validateEmptyInputs();

}
?>
<!DOCTYPE html>
<html lang="fr">
 <head>
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
           integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src='http://production-assets.codepen.io/assets/editor/live/console_runner-079c09a0e3b9ff743e39ee2d5637b9216b3545af0de366d4b9aad9dc87e26bfd.js'
            defer></script>
    <script src='http://production-assets.codepen.io/assets/editor/live/events_runner-73716630c22bbc8cff4bd0f07b135f00a0bdc5d14629260c3ec49e5606f98fdd.js'
            defer></script>
    <script src='http://production-assets.codepen.io/assets/editor/live/css_live_reload_init-2c0dc5167d60a5af3ee189d570b1835129687ea2a61bee3513dee3a50c115a77.js'
            defer></script>
    <meta charset='UTF-8'>
    <meta name="robots" content="noindex">
    <link rel="shortcut icon" type="image/x-icon" href="images/logo_dark.png"/>
     <link rel="stylesheet" href="css/main.css">
    <link rel="mask-icon"  href="http://production-assets.codepen
          .io/assets/favicon/logo-pin-f2d2b6d2c61838f7e76325261b7195c27224080bc099486ddd6dccb469b8e8e6.svg"
          color="#111"/>
    <link rel="canonical" href="https://codepen.io/frytyler/pen/EGdtg"/>

    <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css'>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js' defer></script>
    <title>Signup - Flash Assistance</title>
    <script src='http://production-assets.codepen.io/assets/common/stopExecutionOnTimeout-b2a7b3fe212eaa732349046d8416e00a9dec26eb7fd347590fbced3ab38af52e.js'
            defer>
    </script>
    <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
             integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
             crossorigin="anonymous" defer></script>-->
     <!--<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
             integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
             crossorigin="anonymous" defer></script>-->
     <link rel="stylesheet" href="css/login.css" class="cp-pen-styles">
 </head>
<body>

<?php require_once'header.php' ?>
        <h3><?php echo $_SESSION['valid']['request']  ?? '';
                  echo $_SESSION['error']['request'] ?? '';
                  if(isset($_SESSION['valid']['request']))
                  unset($_SESSION['valid'], $_SESSION['error'])?></h3>
        <div class="signup">
            <form action="" method="post">
                <label>first name
                    <input  type="text" name="firstName" value="<?= $_SESSION['valid']['firstName'] ?? ''
                    ?>" required>
                </label>
                <span class="error"><?= $_SESSION['error']['firstName'] ?? '' ?></span>
                <br>
                <label>last name
                    <input  type="text" name="lastName" value="<?= $_SESSION['valid']['lastName'] ?? '' ?>" required>
                </label>
                <span class="error"><?= $_SESSION['error']['lastName'] ?? '' ?></span>
                <br>
                <label>email
                    <input  type="text" name="email" value="<?= $_SESSION['valid']['email'] ?? '' ?>" required>
                </label>
                <span class="error"><?= $_SESSION['error']['email'] ?? '' ?></span>
                <br>
                <label>phone number
                    <input  type="text" name="phone" value="<?= $_SESSION['valid']['phone'] ?? '' ?>" required>
                </label>
                <span class="error"><?= $_SESSION['error']['phone'] ?? '' ?></span>
                <br>
                <label> password
                    <input  type="password" name="password" required>
                </label>
                <span class="error"><?= $_SESSION['error']['password'] ?? '' ?></span>
                <br>
                <label> retype password
                    <br>
                    <input  type="password" name="rePassword" required>
                </label><br>
                <button type="submit" id="btn" class="btn btn-primary btn-block btn-large">Signup</button>
                <br>
            </form>
        </div>
<?php
unset($_SESSION['error'], $_SESSION['valid']);
?>
<?php require_once'footer.php' ?>
</body>
</html>
