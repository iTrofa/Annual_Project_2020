<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Signup - Flash Assistance</title>
</head>
<body>
<?php
;
if(isset($_POST))
{
    require_once 'InputValidator.php';
    $validate = new InputValidator($_POST);
    $validate->validateEmptyInputs();
}


?>
<form action="" method="POST">
    <label>first name
        <input type="text" name="firstName" value="<?= $_SESSION['valid']['firstName'] ?? '' ?>" required>
    </label>
    <div class="error"><?= $_SESSION['error']['firstName'] ?? '' ?></div>
    <br>
    <label>last name
        <input type="text" name="lastName"  value="<?= $_SESSION['valid']['lastName'] ?? '' ?>" required>
    </label>
    <div class="error"><?= $_SESSION['error']['lastName'] ?? '' ?></div>
    <br>
    <label>email
        <input type="email" name="email" value="<?= $_SESSION['valid']['email'] ?? '' ?>" required>
    </label>
    <div class="error"><?= $_SESSION['error']['email'] ?? '' ?></div>
    <br>
    <label>phone number
        <input type="tel" name="phone" value="<?= $_SESSION['valid']['phone'] ?? '' ?>" required>
    </label>
    <div class="error"><?= $_SESSION['error']['phone'] ?? '' ?></div>
    <br>
    <label> password
        <input type="password" name="password"  required>
    </label>
    <div class="error"><?= $_SESSION['error']['password'] ?? '' ?></div>
    <br>
    <label> retype password
        <br>
        <input type="password" name="rePassword" required>
    </label><br>
    <button type="submit">Signup</button>
    <br>
</form>
</body>
</html>
