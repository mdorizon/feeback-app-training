<?php session_start();

    // check if user building
    $connectDatabase = new PDO("mysql:host=db;dbname=feedback-php", "root", "admin");
    $requestUserBuilding = $connectDatabase->prepare("SELECT * FROM user_building WHERE user_id = :id");
    $requestUserBuilding->bindParam(':id', $_SESSION['id']);
    $requestUserBuilding->execute();
    $isUserBuilding = $requestUserBuilding->fetch(PDO::FETCH_ASSOC);
    if(empty($isUserBuilding)) {
        header("Location: ../index.php");
        die(); 
    }
    if($isUserBuilding['id'] != $_GET['building_user_id']) {
        header("Location: ../index.php");
        die(); 
    }
    $connectDatabase = new PDO("mysql:host=db;dbname=feedback-php", "root", "admin");
    $request = $connectDatabase->prepare("DELETE FROM building WHERE id= :id");
    $request->bindParam(':id', $_GET['building_id']);
    $request->execute();
    header("Location: ../index.php");