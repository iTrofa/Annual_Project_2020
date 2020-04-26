<?php

if (isset($_POST['english']))
{
    $_SESSION['lang'] = "en_US";
} else if (isset($_POST['french']))
{
    $_SESSION['lang'] = "fr_FR";
}
header('Location: signup.php');