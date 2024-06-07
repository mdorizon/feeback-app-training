<?php session_start(); ?>
<?php require_once 'parts/header.php'; ?>

<div class="container w-25 mt-5">
    <h1>Nouvel établissement</h1>

    <form action="scripts/building-create.php" method="POST">
        <div class="mb-3">
            <input class="form-control" type="text" name="name" placeholder="Nom" required>
            <input class="form-control mt-3" placeholder="Adresse" type="text" name="adress" required>
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