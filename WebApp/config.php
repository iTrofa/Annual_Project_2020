<?php
try{
    $bdd = new PDO('mysql:host=localhost:3308;dbname=flashassistance', 'root', 'root');
    /*$bdd->query("SET NAMES 'UTF8'");*/

}
catch (Exception $e)
{
    // En cas d'erreur, on affiche un message et on arrête tout
    die('Erreur : ' . $e->getMessage());
}

?>
