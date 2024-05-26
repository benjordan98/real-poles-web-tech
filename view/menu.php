<!-- <?php $loggedIn = User::isLoggedIn(); ?>

<p>[
    <a href="<?= BASE_URL . "allpolls" ?>"> All polls </a>
    <?php if ($loggedIn) : ?>
        <a href="<?= BASE_URL . "results" ?>"> My polls </a>
    <?php endif; ?>
    <a href="<?= BASE_URL . "poll/add" ?>"> Add poll </a>
    <a href="<?= BASE_URL . "user/login" ?>"> Login </a>
    <a href="<?= BASE_URL . "user/register" ?>"> Register </a>
    <?php if ($loggedIn) : ?>
        <a href="<?= BASE_URL . "user/logout" ?>"> Logout </a>
    <?php endif; ?>
    ]
</p>

<img src="<?= IMAGES_URL . "logo.png" ?>" alt="Logo" style="width: 100px; height: 100px; border-radius: 75%;">

</html> -->

<!doctype html>
<html lang="en">

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
        <nav>
            <div class="menu">
                <div class="menu-item"><a href="<?= BASE_URL . "allpolls" ?>" class="menu-link">All polls</a></div>
                <?php if ($loggedIn) : ?>
                    <div class="menu-item"><a href="<?= BASE_URL . "results" ?>" class="menu-link">My polls</a></div>
                <?php endif; ?>
                <div class="menu-item"><a href="<?= BASE_URL . "poll/add" ?>" class="menu-link">Add poll</a></div>
                <?php if (!$loggedIn) : ?>
                    <div class="menu-item"><a href="<?= BASE_URL . "user/login" ?>" class="menu-link">Login</a></div>
                    <div class="menu-item"><a href="<?= BASE_URL . "user/register" ?>" class="menu-link">Register</a></div>
                <?php else : ?>
                    <div class="menu-item"><a href="<?= BASE_URL . "user/logout" ?>" class="menu-link">Logout</a></div>
                <?php endif; ?>
            </div>
        </nav>
    </header>
</body>