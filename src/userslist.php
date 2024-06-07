<?php session_start(); ?>
<?php
    // connect to db
    $connectDatabase = new PDO("mysql:host=db;dbname=feedback-php", "root", "admin");
    // prepare request
    $request = $connectDatabase->prepare("SELECT user.id, user.username, user.created_at, COUNT(feedback.id) AS feedback_count FROM user LEFT JOIN feedback ON user.id = feedback.user_id GROUP BY user.id, user.username;");
    // execute request
    $request->execute();
    // fetch all data from table posts
    $result = $request->fetchAll(PDO::FETCH_ASSOC);
?>

<?php require_once 'parts/header.php'; ?>

<section class="buildings d-flex flex-column align-items-center mt-5">
    <h2 class="mb-5">Liste des utilisateurs</h2>
    <div class="feedback-list col-9 d-flex gap-4 mb-5 flex-wrap">
        <?php foreach($result as $user): ?>
            <a class="card" style="width: 18rem;" href="./single-user.php?userid=<?= $user['id'] ?>&filter=">
                <div class="card-body">
                    <h5 class="card-subtitle mb-2 text-muted"><?= $user['username'] ?></h5>
                    <p class="card-text"><small class="text-body-secondary">Nombre d'avis: <?= $user['feedback_count'] ?></small></p>
                    <p class="card-text"><small class="text-body-secondary">Compte crée le : <?= $user['created_at'] ?></small></p>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</section>

<?php require_once 'parts/footer.php'; ?>