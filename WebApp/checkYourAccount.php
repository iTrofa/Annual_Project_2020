<?php
require_once 'autoload.php';
if (!empty($_POST))
{
    $validator = new SignupValidator($_POST, $_FILES, true);
    $validator->validateEmptyInputsUpdate();
    unset($_SESSION['res']);
    header('Location: yourAccount.php');
    exit();
}