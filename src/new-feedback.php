<?php require_once 'parts/header.php'; ?>

<div class="container w-25 mt-5">
    <h1>Nouvelle notation</h1>

    <form action="scripts/feedback-create.php" method="POST">
        <div class="mb-3">
            <input class="form-control" type="number" name="note" value="1" min="1" max="5" required>
            <input class="form-control mt-3" placeholder="pseudo" type="text" name="name" required>
            <input class="form-control mt-3" placeholder="email" type="email" name="email" required>
            <textarea class="form-control mt-3" name="message" placeholder="votre message" required></textarea>
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