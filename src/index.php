<?php
    // connect to db
    $connectDatabase = new PDO("mysql:host=db;dbname=feedback-php", "root", "admin");
    // prepare request
    $request = $connectDatabase->prepare("SELECT * FROM `feedback` ORDER BY `created_at` DESC");
    // execute request
    $request->execute();
    // fetch all data from table posts
    $result = $request->fetchAll(PDO::FETCH_ASSOC);
?>

<?php require_once 'parts/header.php'; ?>

<section class="feedbacks d-flex justify-content-center mt-5">

    <div class="filters">
        
    </div>

    <div class="feedback-list col-10 d-flex gap-4">
        <?php foreach($result as $feedback): ?>
            <div class="card" style="width: 18rem;">
                <div class="card-body">
                    <div class="notation d-flex gap-2">
                        <?php for($i = 1; $i <= $feedback['note']; $i++): ?>
                            <h5 class="card-title text-warning">★</h5>
                        <?php endfor; ?>
                    </div>
                    <h6 class="card-subtitle mb-2 text-muted"><?= $feedback['name'] ?></h6>
                    <p class="card-text"><?= $feedback['message'] ?></p>
                    <p class="card-text"><small class="text-body-secondary">Note donnée le : <?= $feedback['created_at'] ?></small></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<?php require_once 'parts/footer.php'; ?>