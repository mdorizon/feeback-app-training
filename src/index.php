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
        <?php foreach($result as $building): ?>
            <div class="card" style="width: 18rem;">
                <?php if(!empty($isUserBuilding)): ?>
                    <?php if($isUserBuilding['id'] == $building['user_building_id']): ?>
                        <a class="text-danger mt-1 ms-3" href="./modify-building.php?building_user_id=<?= $building['user_building_id'] ?>&building_id=<?= $building['id'] ?>">modifier ✎</a>
                        <a class="text-danger mt-1 ms-3" href="./scripts/building-delete.php?building_user_id=<?= $building['user_building_id'] ?>&building_id=<?= $building['id'] ?>">supprimer ♻︎</a>
                    <?php endif;  ?>
                <?php endif; ?>
                <a class="card-body" href="./single-building.php?building_id=<?= $building['id'] ?>&filter=">
                    <div class="notation d-flex gap-1">
                        <?php for($i = 1; $i <= $building['review_moy']; $i++): ?>
                            <h5 class="card-title text-warning">★</h5>
                        <?php endfor; ?>
                        <?php if($building['review_moy'] < 5): ?>
                            <?php for($i = 1; $i <= (5 - $building['review_moy']); $i++): ?>
                                <h5 class="card-title text-secondary">★</h5>
                            <?php endfor; ?>
                        <?php endif; ?>
                    </div>
                    <h5 class="card-subtitle mb-2 text-muted"><?= $building['name'] ?></h5>
                    <p class="card-text"><small class="text-body-secondary">Adresse : <?= $building['adress'] ?></small></p>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
    <?php if(!empty($isUserBuilding)) : ?>
        <a href="./new-building.php" class="mt-5">Ajouter un nouvel établissement</a>
    <?php endif; ?>
</section>

<?php require_once 'parts/footer.php'; ?>