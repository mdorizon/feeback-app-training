<?php
    session_start();

    $connectDatabase = new PDO("mysql:host=db;dbname=feedback-php", "root", "admin");
    $requestUserBuilding = $connectDatabase->prepare("SELECT * FROM user_building WHERE user_id = :id");
    $requestUserBuilding->bindParam(':id', $_SESSION['id']);
    $requestUserBuilding->execute();
    $isUserBuilding = $requestUserBuilding->fetch(PDO::FETCH_ASSOC);

    $name   = $_POST['name'];
    $adress = $_POST['adress'];
    $id     = $_POST['id'];

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
    $request = $connectDatabase->prepare("UPDATE building SET name=:name, adress=:adress WHERE id= :id");
    // bind params
    $request->bindParam(':name', $name);
    $request->bindParam(':adress', $adress);
    $request->bindParam(':id', $id);
    // execute request
    $request->execute();

    header("Location: ../index.php");