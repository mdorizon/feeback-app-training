<?php require_once 'parts/header.php'; ?>

<div class="container w-25 mt-5">
    <h1>Signup page</h1>
    <form action="scripts/register.php" method="POST" class="mb-3 mt-3">
        <div class="mb-3">
            <input type="text" class="form-control" placeholder="Enter Username" name="username">
        </div>
        <div class="mb-3">
            <input type="email" class="form-control" placeholder="Enter Email" name="email">
        </div>
        <div class="mb-3">
            <input type="password" class="form-control" placeholder="Enter password" name="password">
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="client_type" id="client_type_1" value="client" checked>
            <label class="form-check-label" for="client_type_1">
                Compte client
            </label>
        </div>
        <div class="form-check mb-3">
            <input class="form-check-input" type="radio" name="client_type" id="client_type_2" value="building">
            <label class="form-check-label" for="client_type_2">
                Compte établissement
            </label>
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
        <input type="submit" class="btn btn-primary w-100" value="Signup">
    </form>
    <p class="text-center">
        Already have an account
        <a href="index.php">Signin</a>
    </p>
</div>