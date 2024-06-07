<?php 

if(empty($_POST['username'])) {
    header("Location: ../signin.php?error=Veuillez renseigner un nom d'utilisateur");
    die();
}
if(empty($_POST['password'])) {
    header("Location: ../signin.php?error=Veuillez renseigner un mot de passe");
    die();
}

// connect to db
$connectDatabase = new PDO("mysql:host=db;dbname=feedback-php", "root", "admin");
// prepare request
$request = $connectDatabase->prepare("SELECT * FROM user WHERE username = :username");
// bindparams (pour proteger des injections)
$request->bindParam(':username', $_POST['username']);
// execute request
$request->execute();
$result = $request->fetch(PDO::FETCH_ASSOC);

if(!$result) {
    header("Location: ../signin.php?error=Utilisateur introuvable !");
    die();
}

$isValidPassword = password_verify($_POST['password'], $result['password']);

if(!$isValidPassword) {
    header("Location: ../signin.php?error=Utilisateur ou mot de passe incorrect !");
    die();
}

session_start();
$_SESSION["username"]=$_POST['username'];
$_SESSION["id"]= $result['id'];

header("Location: ../index.php");