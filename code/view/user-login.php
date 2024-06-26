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
    <div class="login-container">
        <main class="form-signin">
            <form action="<?= BASE_URL . "user/login" ?>" method="POST">
                <?php if (!empty($errorMessage)) : ?>
                    <p class="important"><?= $errorMessage ?></p>
                <?php endif; ?>
                <?php
                if (isset($_GET['error'])) {
                    $errorMessage = htmlspecialchars($_GET['error']);
                    echo "<p class='important'>{$errorMessage}</p>";
                }
                ?>
                <h1>Log in</h1>
                <div>
                    <label for="usernameInput">Username</label>
                    <input type="text" name="username" class="form-control" id="usernameInput" placeholder="username" pattern="[a-zA-Z0-9]+">
                </div>
                <div>
                    <label for="passwordInput">Password</label>
                    <input type="password" name="password" class="form-control" id="passwordInput" placeholder="password" required>
                </div>
                <div>
                    <input type="checkbox" id="togglePassword">
                    <label id="togglePasswordLabel" for="togglePassword">Show Password</label>
                </div>
                <button type="submit">Log in</button>
            </form>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const usernameInput = document.getElementById("usernameInput");
            const form = document.querySelector('form');

            usernameInput.addEventListener('input', function() {
                const pattern = /^[a-zA-Z0-9]+$/;
                if (!pattern.test(this.value)) {
                    this.setCustomValidity("Username can only contain letters and numbers.");
                } else {
                    this.setCustomValidity("");
                }
                this.reportValidity();
            });

            form.addEventListener('submit', function(event) {
                if (!usernameInput.checkValidity()) {
                    event.preventDefault();
                    usernameInput.reportValidity();
                }
            });

            const togglePassword = document.querySelector('#togglePassword');
            const passwordInput = document.querySelector('#passwordInput');

            togglePassword.addEventListener('change', function() {
                const type = passwordInput.type === 'password' ? 'text' : 'password';
                passwordInput.type = type;
                const label = document.getElementById("togglePasswordLabel");
                label.textContent = label.textContent === "Show Password" ? "Hide Password" : "Show Password";
            });
        });
    </script>
</body>

</html>