<?php
$hash_password = password_hash($_POST['password'], PASSWORD_DEFAULT);

if(empty($_POST['username'])) {
    header("Location: ../signup.php?error=Veuillez renseigner un nom d'utilisateur");
    die();
}
if(empty($_POST['password'])) {
    header("Location: ../signup.php?error=Veuillez renseigner un mot de passe");
    die(); 
}

// connect to db with PDO
$connectDatabase = new PDO("mysql:host=db;dbname=feedback-php", "root", "admin");
// prepare request
$request = $connectDatabase->prepare("INSERT INTO user (username, password) VALUES (:username, :password)");
// bind params
$request->bindParam(':username', $_POST['username']);
$request->bindParam(':password', $hash_password);
// execute request
$request->execute();

// connect to db
$connectDatabase = new PDO("mysql:host=db;dbname=feedback-php", "root", "admin");
// prepare request
$request = $connectDatabase->prepare("SELECT * FROM user WHERE username = :username");
// bindparams (pour proteger des injections)
$request->bindParam(':username', $_POST['username']);
// execute request
$request->execute();
$result = $request->fetch(PDO::FETCH_ASSOC);

session_start();
$_SESSION["username"]=$_POST['username'];
$_SESSION["id"]= $result['id'];

header("Location: ../index.php");