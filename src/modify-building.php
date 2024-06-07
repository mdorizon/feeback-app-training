<?php session_start(); ?>
<?php 
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
?>

<?php require_once 'parts/header.php'; ?>
<?php 
$connectDatabase = new PDO("mysql:host=db;dbname=feedback-php", "root", "admin");
$request = $connectDatabase->prepare("SELECT * FROM building WHERE id = :id");
$request->bindParam(':id', $_GET['building_id']);
$request->execute();
$result = $request->fetch(PDO::FETCH_ASSOC);
?>

<div class="container w-25 mt-5">
    <h1>Nouvel établissement</h1>

    <form action="scripts/building-modify.php" method="POST">
        <div class="mb-3">
            <input type="hidden" name="id" value="<?= $_GET['building_id'] ?>">
            <input class="form-control" type="text" name="name" placeholder="Nom" value="<?= $result['name'] ?>" required>
            <input class="form-control mt-3" placeholder="Adresse" type="text" name="adress" value="<?= $result['adress'] ?>" required>
        </div>

        <?php if(isset($_GET['error'])) : ?>
        <div class="alert alert-danger">
            <?php echo htmlspecialchars($_GET['error']); ?>
        </div>
        <?php endif; ?>
        
        <?php if(isset($_GET['success'])) : ?>
            <div class="alert alert-success">
            <?php echo htmlspecialchars($_GET['success']); ?>
            </div>
        <?php endif; ?>

        <input type="submit" class="btn btn-primary w-100" value="Envoyer">
    </form>
</div>

<?php require_once 'parts/footer.php'; ?>