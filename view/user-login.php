<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign in</title>
    <!-- <link rel="stylesheet" type="text/css" href="<?= CSS_URL . "login.css" ?>"> -->
</head>

<body class="text-center">
    <main class="form-signin">
        <form action="<?= BASE_URL . "user/login" ?>" method="POST">
            <?php if (!empty($errorMessage)) : ?>
                <p class="important"><?= $errorMessage ?></p>
            <?php endif; ?>
            <!-- <a href="<?= BASE_URL ?>"><img src="<?= IMAGES_URL . "home_black_24dp.svg" ?>" alt="Home button"></a> -->
            <h1>Please log in</h1>
            <div>
                <input type="text" name="username" class="form-control" id="usernameInput" placeholder="username" pattern="[a-zA-Z0-9]+">
                <label for="usernameInput">Username</label>
            </div>
            <div>
                <input type="password" name="password" class="form-control" id="passwordInput" placeholder="password" required>
                <label for="passwordInput">Password</label>
            </div>
            <button type="submit">Log in</button>
        </form>
    </main>


</body>

</html>