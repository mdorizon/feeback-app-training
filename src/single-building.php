<?php session_start(); ?>
<?php
    switch ($_GET['filter']) {
        case 'desc':
            $filter = "created_at DESC";
            break;
        case 'asc':
            $filter = "created_at ASC";
            break;
        case 'most':
            $filter = "note DESC";
            break;
        case 'least':
            $filter = "note ASC";
            break;
        default:
            $filter = "created_at DESC";
            break;
    }
    // connect to db
    $connectDatabase = new PDO("mysql:host=db;dbname=feedback-php", "root", "admin");
    // prepare request
    $request = $connectDatabase->prepare("SELECT feedback.*, user.username FROM feedback JOIN user ON feedback.user_id = user.id where building_id = :id ORDER BY {$filter}");
    // bindParams
    $request->bindParam(':id', $_GET['building_id']);
    // execute request
    $request->execute();
    // fetch all data from table posts
    $result = $request->fetchAll(PDO::FETCH_ASSOC);
?>

<?php require_once 'parts/header.php'; ?>

<section class="feedbacks d-flex flex-column align-items-center mt-5">
    <h2 class="mb-5">Notes de l'établissement</h2>
    <div class="filters mb-5">
        <form id="filterForm">
            <input type="hidden" value="<?= $_GET['building_id'] ?>" name="building_id">
            <select name="filter" class="form-select" onchange="submitForm()">
                <option value="desc" <?= $_GET['filter'] == 'desc' ? "selected" : "" ?>>Plus récents</option>
                <option value="asc" <?= $_GET['filter'] == 'asc' ? "selected" : "" ?>>Plus anciens</option>
                <option value="most" <?= $_GET['filter'] == 'most' ? "selected" : "" ?>>Mieux notés</option>
                <option value="least" <?= $_GET['filter'] == 'least' ? "selected" : "" ?>>Moins bien notés</option>
            </select>
        </form>
        <script>
            function submitForm() { document.getElementById('filterForm').submit(); }
        </script>
    </div>

    <div class="feedback-list col-9 d-flex gap-4 flex-wrap mb-5">
        <?php foreach($result as $feedback): ?>
            <div class="card" style="width: 18rem;">
                <div class="card-body">
                    <div class="notation d-flex gap-1">
                        <?php for($i = 1; $i <= $feedback['note']; $i++): ?>
                            <h5 class="card-title text-warning">★</h5>
                        <?php endfor; ?>
                        <?php if($feedback['note'] < 5): ?>
                            <?php for($i = 1; $i <= (5 - $feedback['note']); $i++): ?>
                                <h5 class="card-title text-secondary">★</h5>
                            <?php endfor; ?>
                        <?php endif; ?>
                    </div>
                    <h5 class="card-subtitle mb-2 text-muted"><?= $feedback['username'] ?></h5>
                    <p class="card-text"><?= $feedback['message'] ?></p>
                    <?php $date = new DateTimeImmutable($feedback['created_at']); ?>
                    <p class="card-text"><small class="text-body-secondary">Note donnée le : <?= $date->format('d-m-Y'); ?></small></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php if(isset($_SESSION['username'])) : ?>
        <a href="./new-feedback.php?building_id=<?= $_GET['building_id']?>" class="mt-5">Ajouter une note à l'établissement</a>
    <?php endif; ?>
</section>

<?php require_once 'parts/footer.php'; ?>