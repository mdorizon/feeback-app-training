<?php
$hash_password = password_hash($_POST['password'], PASSWORD_DEFAULT);

if(empty($_POST['username'])) {
    header("Location: ../signup.php?error=Veuillez renseigner un nom d'utilisateur");
    die();
}
if (empty($_POST['email'])) {
    header("Location: ../signin.php?error=Veuillez renseigner un email");
    die();
}
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    header("Location: ../signin.php?error=Veuillez renseigner un email valide");
    die();
}
if(empty($_POST['password'])) {
    header("Location: ../signup.php?error=Veuillez renseigner un mot de passe");
    die(); 
}

// connect to db with PDO
try {
    $connectDatabase = new PDO("mysql:host=db;dbname=feedback-php", "root", "admin");
    // prepare request
    $request = $connectDatabase->prepare("INSERT INTO user (username, email, password) VALUES (:username, :email, :password)");
    // bind params
    $request->bindParam(':username', $_POST['username']);
    $request->bindParam(':email', $_POST['email']);
    $request->bindParam(':password', $hash_password);
    // execute request
    $request->execute();
} catch (\Throwable $th) {
    header("Location: ../signup.php?error=Adresse email déjà utilisée !");
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

session_start();
$_SESSION["username"]=$_POST['username'];
$_SESSION["id"]= $result['id'];

header("Location: ../index.php");