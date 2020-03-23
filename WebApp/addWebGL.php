<?php
?>
<html>
    <body>
        <form method="post" enctype="multipart/form-data">
            <label>Demo Directory Name</label><br><br>
            <input type="text" name="fileDir"><br><br>
            <label> Demo Zip File</label><br><br>
            <input type="file" name="fileName"><br><br>
            <input type="submit" name="fileSubmit" value="Submit Demo">
        </form>
    </body>
</html>
<?php
// Get Project path
define('_PATH', dirname(__FILE__));
var_dump($_FILES);
echo "<br>";
var_dump($_POST);
// Zip file name
if(!empty($_FILES) && !empty($_POST['fileDir'])){
    $filename = $_FILES["fileName"]["tmp_name"];
    $zip = new ZipArchive;
    $res = $zip->open($filename);
    echo $res;
    if ($res === TRUE) {

        // Unzip path
        $path = _PATH . "/WebGL/". $_POST['fileDir']. "/";

        // Extract file
        $zip->extractTo($path);
        $zip->close();

        echo 'Unzip!';
    } else {
        echo 'failed!';
    }
}