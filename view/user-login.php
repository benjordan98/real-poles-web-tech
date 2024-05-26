<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign in</title>
    <link rel="stylesheet" type="text/css" href="<?= CSS_URL . "login.css" ?>">
</head>

<body>
    <?php include("view/menu.php"); ?>
    <div class="login-container"> <!-- Added container to wrap the form -->
        <main class="form-signin">
            <form action="<?= BASE_URL . "user/login" ?>" method="POST">
                <?php if (!empty($errorMessage)) : ?>
                    <p class="important"><?= $errorMessage ?></p>
                <?php endif; ?>
                <h1>Please log in</h1>
                <div>
                    <label for="usernameInput">Username</label>
                    <input type="text" name="username" class="form-control" id="usernameInput" placeholder="username" pattern="[a-zA-Z0-9]+">
                </div>
                <div>
                    <label for="passwordInput">Password</label>
                    <input type="password" name="password" class="form-control" id="passwordInput" placeholder="password" required>
                </div>
                <button type="submit">Log in</button>
            </form>
        </main>
    </div>
</body>

</html>