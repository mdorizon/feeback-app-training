<?php
    session_start();
    if(!isset($_SESSION['username'])) {
        header("Location: ../index.php");
    }

    $connectDatabase = new PDO("mysql:host=db;dbname=feedback-php", "root", "admin");
    $requestUserBuilding = $connectDatabase->prepare("SELECT * FROM user_client WHERE user_id = :id");
    $requestUserBuilding->bindParam(':id', $_SESSION['id']);
    $requestUserBuilding->execute();
    $isUserClient = $requestUserBuilding->fetch(PDO::FETCH_ASSOC);

    if(!isset($isUserClient)) {
        header("Location: ../index.php");
    }

    $message     = $_POST['message'];
    $note        = $_POST['note'];
    $building    = $_POST['building'];

    if(empty($message)) {
        header("Location: ../new-feedback.php?error=Veuillez renseigner un message");
        die();
    }
    if($note <= 0 || $note > 5) {
        header("Location: ../new-feedback.php?error=Veuillez renseigner une notation valide");
        die();
    }

    // connect to db with PDO
    $connectDatabase = new PDO("mysql:host=db;dbname=feedback-php", "root", "admin");
    // prepare request
    $request = $connectDatabase->prepare("INSERT INTO feedback (message, note, building_id, user_client_id) VALUES (:message, :note, :building, :user_client_id)");
    // bind params
    $request->bindParam(':user_client_id', $isUserClient['id']);
    $request->bindParam(':message', $message);
    $request->bindParam(':note', $note);
    $request->bindParam(':building', $building);
    // execute request
    $request->execute();

    // calculate building moy notation
    $connectDatabase = new PDO("mysql:host=db;dbname=feedback-php", "root", "admin");
    $moy = $connectDatabase->prepare("SELECT note FROM feedback WHERE building_id = :building");
    $moy->bindParam(':building', $building);
    $moy->execute();
    $moy_result = $moy->fetchAll(PDO::FETCH_ASSOC);
    $moyenne = 0;
    foreach($moy_result as $moy) {
        $moyenne += $moy['note'];
    }
    $moyenne /= count($moy_result);

    // set the new building moy
    $connectDatabase = new PDO("mysql:host=db;dbname=feedback-php", "root", "admin");
    $request = $connectDatabase->prepare("UPDATE building SET review_moy = :moyenne WHERE id = :id");
    $request->bindParam(':id', $building);
    $request->bindParam(':moyenne', $moyenne);
    // execute request
    $request->execute();

    header("Location: ../index.php");