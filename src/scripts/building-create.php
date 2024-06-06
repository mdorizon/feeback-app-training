<?php
    session_start();

    $name   = $_POST['name'];
    $adress = $_POST['adress'];

    if(empty($name)) {
        header("Location: ../new-feedback.php?error=Veuillez renseigner un nom");
        die();
    }
    if (empty($adress)) {
        header("Location: ../new-feedback.php?error=Veuillez renseigner un email");
        die();
    }

    // connect to db with PDO
    $connectDatabase = new PDO("mysql:host=db;dbname=feedback-php", "root", "admin");
    // prepare request
    $request = $connectDatabase->prepare("INSERT INTO building (name, adress) VALUES (:name, :adress)");
    // bind params
    $request->bindParam(':name', $name);
    $request->bindParam(':adress', $adress);
    // execute request
    $request->execute();

    header("Location: ../index.php");