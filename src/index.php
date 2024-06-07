<?php session_start(); ?>
<?php
    // connect to db
    $connectDatabase = new PDO("mysql:host=db;dbname=feedback-php", "root", "admin");
    // prepare request
    $request = $connectDatabase->prepare("SELECT * FROM `building` ORDER BY review_moy DESC");
    // execute request
    $request->execute();
    // fetch all data from table posts
    $result = $request->fetchAll(PDO::FETCH_ASSOC);

    // check if user building
    $connectDatabase = new PDO("mysql:host=db;dbname=feedback-php", "root", "admin");
    $requestUserBuilding = $connectDatabase->prepare("SELECT * FROM user_building WHERE user_id = :id");
    $requestUserBuilding->bindParam(':id', $_SESSION['id']);
    $requestUserBuilding->execute();
    $isUserBuilding = $requestUserBuilding->fetch(PDO::FETCH_ASSOC);
?>

<?php require_once 'parts/header.php'; ?>

<section class="buildings d-flex flex-column align-items-center mt-5">
    <h2 class="mb-5">Liste des établissements</h2>
    <div class="feedback-list col-9 d-flex gap-4 mb-5 flex-wrap">
        <?php foreach($result as $feedback): ?>
            <a class="card" style="width: 18rem;" href="./single-building.php?building_id=<?= $feedback['id'] ?>&filter=">
                <div class="card-body">
                    <div class="notation d-flex gap-1">
                        <?php for($i = 1; $i <= $feedback['review_moy']; $i++): ?>
                            <h5 class="card-title text-warning">★</h5>
                        <?php endfor; ?>
                        <?php if($feedback['review_moy'] < 5): ?>
                            <?php for($i = 1; $i <= (5 - $feedback['review_moy']); $i++): ?>
                                <h5 class="card-title text-secondary">★</h5>
                            <?php endfor; ?>
                        <?php endif; ?>
                    </div>
                    <h5 class="card-subtitle mb-2 text-muted"><?= $feedback['name'] ?></h5>
                    <p class="card-text"><small class="text-body-secondary">Adresse : <?= $feedback['adress'] ?></small></p>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
    <?php if(!empty($isUserBuilding)) : ?>
        <a href="./new-building.php" class="mt-5">Ajouter un nouvel établissement</a>
    <?php endif; ?>
</section>

<?php require_once 'parts/footer.php'; ?>