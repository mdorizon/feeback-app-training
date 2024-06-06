<?php
    session_start();

    $name        = $_POST['name'];
    $email       = $_POST['email'];
    $message     = $_POST['message'];
    $note        = $_POST['note'];
    $building    = $_POST['building'];

    if(empty($name)) {
        header("Location: ../new-feedback.php?error=Veuillez renseigner un nom");
        die();
    }
    if (empty($email)) {
        header("Location: ../new-feedback.php?error=Veuillez renseigner un email");
        die();
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../new-feedback.php?error=Veuillez renseigner un email valide");
        die();
    }
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
    $request = $connectDatabase->prepare("INSERT INTO feedback (name, email, message, note, building_id) VALUES (:name, :email, :message, :note, :building)");
    // bind params
    $request->bindParam(':name', $name);
    $request->bindParam(':email', $email);
    $request->bindParam(':message', $message);
    $request->bindParam(':note', $note);
    $request->bindParam(':building', $building);
    // execute request
    $request->execute();

    // connect to db with PDO
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

    // connect to db with PDO
    $connectDatabase = new PDO("mysql:host=db;dbname=feedback-php", "root", "admin");
    $request = $connectDatabase->prepare("UPDATE building SET review_moy = :moyenne WHERE id = :id");
    $request->bindParam(':id', $building);
    $request->bindParam(':moyenne', $moyenne);
    // execute request
    $request->execute();

    header("Location: ../index.php");