<!doctype html>
<html lang="en">

<?php $loggedIn = isset($_SESSION["user_id"]); ?>

<?php $currentPage = basename($_SERVER["REQUEST_URI"]); ?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign in</title>
    <link rel="stylesheet" type="text/css" href="<?= CSS_URL . "menu.css" ?>"> <!-- Ensure this path is correct -->
</head>

<body>
    <header>
        <div class="logo-container">
            <img src="<?= IMAGES_URL . "logo.png" ?>" alt="Logo">
        </div>
        <div class="title">
            <h1>Real Poles</h1>
        </div>
        <h1><?= $currentPage ?></h1>
        <nav>
            <div class="menu">
                <a href="<?= BASE_URL . "allpolls" ?>" class="menu-link <?= ($currentPage == 'allpolls') ? 'menu-link-active' : '' ?>">All polls</a>
                <?php if ($loggedIn) : ?>
                    <a href="<?= BASE_URL . "results" ?>" class="menu-link <?= ($currentPage == 'results') ? 'menu-link-active' : '' ?>">My polls</a>
                    <a href="<?= BASE_URL . "poll/add" ?>" class="menu-link <?= ($currentPage == 'add') ? 'menu-link-active' : '' ?>">Add poll</a>
                <?php endif; ?>
                <?php if (!$loggedIn) : ?>
                    <a href="<?= BASE_URL . "user/login" ?>" class="menu-link <?= ($currentPage == 'login') ? 'menu-link-active' : '' ?>">Login</a>
                    <a href="<?= BASE_URL . "user/register" ?>" class="menu-link <?= ($currentPage == 'register') ? 'menu-link-active' : '' ?>">Register</a>
                <?php else : ?>
                    <a href="<?= BASE_URL . "user/logout" ?>" class="menu-link">Logout</a>
                <?php endif; ?>
            </div>
        </nav>
    </header>
</body>