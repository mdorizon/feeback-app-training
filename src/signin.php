<?php session_start(); ?>
<?php require_once 'parts/header.php'; ?>

<div class="container w-25 mt-5">
    <h1>Signin page</h1>
    <form action="scripts/login.php" method="POST" class="mb-3 mt-3">
        <div class="mb-3">
            <input type="email" class="form-control" placeholder="Enter email" name="email">
        </div>
        <div class="mb-3">
            <input type="password" class="form-control" placeholder="Enter password" name="password">
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
        <input type="submit" class="btn btn-primary w-100" value="Signin">
    </form>
    <p class="text-center">
        You don't have an account
        <a href="./signup.php">Signup</a>
    </p>
</div>

<?php require_once 'parts/footer.php'; ?>