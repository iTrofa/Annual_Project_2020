
<?php
require('config.php');
include('header.php');
echo "<title>Flash Assistance</title>";
echo "<body>";

echo "<br><br><br><br>";
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
 //List of Workers
$q = "SELECT * FROM person";
$req = $bdd->prepare($q);
$req->execute();

$results = [];
while($user = $req->fetch()) {
    $results[] = $user;
}
?>
<div class="container">
    <h2>List of all workers:</h2>
    <input class='form-control mb-4' id='tableSearch' type='text' placeholder='Type something to search list items'>
  <table class="table">
    <thead>
      <tr>
          <th>ID</th>
          <th>Firstname</th>
          <th>Lastname</th>
          <th>Email</th>
          <th>Phone Number</th>
          <th>Password</th>
          <th>Function</th>
          <th>Localisation</th>
      </tr>
    </thead>
    <tbody id="myTable">
<?php

for ($i = 0 ; $i<sizeof($results); $i++){
    $firstName = $results[$i]['firstName'];
    $lastName = $results[$i]['lastName'];
    $email = $results[$i]['email'];
    $phone = $results[$i]['phoneNumber'];
    $password = $results[$i]['password'];
    $idPerson = $results[$i]['idPerson'];
    $function = $results[$i]['function'];
    $localisation = $results[$i]['localisation'];
   /* $q = $bdd->prepare("SELECT idPerson FROM worker where idPerson = :idPerson");
    $q->bindParam(':idPerson', $idPerson);
    $q->execute();
    $worker = $q->fetchall();
    $worker = $worker[0]['idPerson'];
    if($worker == ""){
        $worker = "Not a worker";
    }else{
        $worker = "Worker";
    }*/
    echo "<tr>";
        echo "<td>".$idPerson."</td>";
        echo "<td>".$firstName."</td>";
        echo "<td>".$lastName."</td>";
        echo "<td>".$email."</td>";
        echo "<td>".$phone."</td>";
        echo "<td>".$password."</td>";
        echo "<td>".$function."</td>";
        echo "<td>".$localisation."</td>";
    echo "</tr>";
   /* echo $i+1 .'- <b>idPerson</b> : ' . $idPerson;
    echo '<br>';
    echo $i+1 . '- <b>First Name</b> : ' . $firstName;
    echo '<br>';
    echo $i+1 . '- <b>Last Name</b> : ' . $lastName;
    echo '<br>';
    echo $i+1 .'- <b>Email</b> : ' . $email;
    echo '<br>';
    echo $i+1 .'- <b>Phone Number</b> : ' . $phone;
    echo '<br>';
    echo $i+1 .'- <b>Password</b> : ' . $password;
    echo '<br>';
    echo $i+1 .'- <b>Function</b> : ' . $worker;
    echo '<br>';
   */
   }
?>
        </tbody>
    </table>
</div>
<br>
<br>
<br>



<?php

/*
 //CONNEXION
 if(!empty($_POST['email'])) {
    $q = $bdd->prepare('SELECT password from person where email = :email ');
    $q->bindParam(':email', $_POST['email']);
    $q->execute();
    $res = $q->fetchall();
 /*   echo $res[0]['password'];
    echo $_POST['password'];*/
//$correctPassword = password_verify($_POST["password"], $res[0]['password']);
/*    if ($_POST["password"] != $res[0]['password']){
        $correctPassword = 0;
    }else{
        $correctPassword = 1;
    }
/*echo $correctPassword;*/
/*}

    echo "<h1>CONNECTION PAGE.</h1>";
    echo "<form method='post'>";
    echo "<label>Email: </label>";
    echo "<input type='email' name='email'/>";
    echo "<br>";
    echo "<label>Password: </label>";
    echo "<input type='password' name='password'/><br>";
    echo "<input type='submit' value='Access'/>";
    echo "</form>";

if (isset($_POST['password']) && !empty($_POST['password'])) {
    if ($correctPassword) {
        session_start();
        $_SESSION['password'] = $_POST['password'];
/*        echo "C BON";*/
     /*   header('location:config.php');
        exit;
    } else {
        echo '<h1>Password incorrect ! Try again.</h1>';
    }
}
*/
 echo "</body>";
include ("footer.php");



