<?php 

if (empty($_POST['email'])) {
    header("Location: ../signin.php?error=Veuillez renseigner un email");
    die();
}
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    header("Location: ../signin.php?error=Veuillez renseigner un email valide");
    die();
}
if(empty($_POST['password'])) {
    header("Location: ../signin.php?error=Veuillez renseigner un mot de passe");
    die();
}

// connect to db
$connectDatabase = new PDO("mysql:host=db;dbname=feedback-php", "root", "admin");
// prepare request
$request = $connectDatabase->prepare("SELECT * FROM user WHERE email = :email");
// bindparams (pour proteger des injections)
$request->bindParam(':email', $_POST['email']);
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
$_SESSION["username"]=$result['username'];
$_SESSION["id"]= $result['id'];

header("Location: ../index.php");