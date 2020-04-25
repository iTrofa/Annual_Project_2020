<?php
require_once "session.php";
require_once "localization.php";

$q =$DbManager->getDb()->prepare("SELECT admin FROM Person Where idPerson = ?");
$q->execute([
    $_SESSION['id']
]);
$res = $q->fetchAll();
if(!$res[0]['admin']){
    header('Location: main.php');
    exit;
}
?>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="images/logo_dark.png"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>-->
    <link rel="stylesheet" href="css/main.css">
    <title>Flash Assistance</title>
    <script src="javascript/header.js"></script>
    <script src="javascript/footer.js"></script>
</head>
    <body onload="checkFooter()">
    <?php
    require_once "header.php";
    ?>
    <main>
        <form method="post" enctype="multipart/form-data" style="text-align: center">
            <label><?=_("Demo File Name")?></label><br><br>
            <input type="text" name="fileDir"><br><br>
            <label><?=_("Demo Zip File (Only Zip Files Allowed)")?></label><br><br>
            <input type="file" name="fileName"><br><br>
            <input type="submit" name="fileSubmit" value="<?=_('Submit Demo')?>">
        </form>
    </main>
    <?php
    require_once "footer.php";
    ?>
    </body>
</html>
<?php
// Get Project path
define('_PATH', dirname(__FILE__));

// Zip file name
if(!empty($_FILES) && !empty($_POST['fileDir'])){
    $filename = $_FILES["fileName"]["tmp_name"];
    $zip = new ZipArchive();
    $res = $zip->open($filename);
    echo $res;
    if ($res === TRUE && $zip->locateName($_POST['fileDir']) !== false) {

        // Unzip path
        $path = _PATH . "/WebGL/". $_POST['fileDir']. "/";

        // Extract file
        $zip->extractTo($path);
        $zip->close();

        echo 'Unzip!';
    } else {
        echo "the file can't be open or the name is not existing";
    }
}