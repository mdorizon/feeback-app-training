<?php
    session_start();

    $connectDatabase = new PDO("mysql:host=db;dbname=feedback-php", "root", "admin");
    $requestUserBuilding = $connectDatabase->prepare("SELECT * FROM user_building WHERE user_id = :id");
    $requestUserBuilding->bindParam(':id', $_SESSION['id']);
    $requestUserBuilding->execute();
    $isUserBuilding = $requestUserBuilding->fetch(PDO::FETCH_ASSOC);

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
    $request = $connectDatabase->prepare("INSERT INTO building (name, adress, user_building_id) VALUES (:name, :adress, :user_building_id)");
    // bind params
    $request->bindParam(':name', $name);
    $request->bindParam(':adress', $adress);
    $request->bindParam(':user_building_id', $isUserBuilding['id']);
    // execute request
    $request->execute();

    header("Location: ../index.php");