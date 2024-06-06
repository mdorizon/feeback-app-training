<?php
    switch ($_GET['filter']) {
        case 'desc':
            $filtertest = "created_at DESC";
            break;
        case 'asc':
            $filtertest = "created_at ASC";
            break;
        case 'most':
            $filtertest = "note DESC";
            break;
        case 'least':
            $filtertest = "note ASC";
            break;
        default:
            $filtertest = "created_at DESC";
            break;
    }
    // connect to db
    $connectDatabase = new PDO("mysql:host=db;dbname=feedback-php", "root", "admin");
    // prepare request
    $request = $connectDatabase->prepare("SELECT * FROM `feedback` ORDER BY {$filtertest}");
    // execute request
    $request->execute();
    // fetch all data from table posts
    $result = $request->fetchAll(PDO::FETCH_ASSOC);
?>

<?php require_once 'parts/header.php'; ?>

<section class="feedbacks d-flex flex-column align-items-center mt-5">

    <div class="filters mb-5">
        <form id="filterForm">
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

    <div class="feedback-list col-9 d-flex gap-4 flex-wrap">
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
                    <h5 class="card-subtitle mb-2 text-muted"><?= $feedback['name'] ?></h5>
                    <p class="card-text"><?= $feedback['message'] ?></p>
                    <p class="card-text"><small class="text-body-secondary">Note donnée le : <?= $feedback['created_at'] ?></small></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<?php require_once 'parts/footer.php'; ?>