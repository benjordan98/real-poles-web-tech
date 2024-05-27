<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign in</title>
    <link rel="stylesheet" type="text/css" href="<?= CSS_URL . "register.css" ?>">
</head>

<body>
    <?php include("view/menu.php"); ?>
    <div class="register-container">
        <main class="form-signup">
            <form action="<?= BASE_URL . "user/register" ?>" method="POST">
                <?php if (!empty($errorMessage)) : ?>
                    <p class="important"><?= $errorMessage ?></p>
                <?php endif; ?>
                <h1>Sign-up</h1>
                <div>
                    <label for="usernameInput">Username</label>
                    <input type="text" name="username" class="form-control" id="usernameInput" placeholder="username" pattern="[a-zA-Z0-9]+" required>
                </div>
                <div>
                    <label for="passwordInput">Password</label>
                    <input type="password" name="password" class="form-control" id="passwordInput" placeholder="password" required>
                </div>
                <div>
                    <label for="password2Input">Repeat password</label>
                    <input type="password" name="password2" class="form-control" id="password2Input" placeholder="password" required>
                </div>
                <div>
                    <input type="checkbox" id="togglePassword">
                    <label id="togglePasswordLabel" for="togglePassword">Show Password</label>
                </div>
                <button type="submit">Sign up</button>
            </form>
        </main>
    </div>
</body>
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
    });

    let togglePasswordRegister = document.querySelector('#togglePassword');
    let passwordInputReg = document.querySelector('#passwordInput');
    let password2InputReg = document.querySelector('#password2Input');

    togglePasswordRegister.addEventListener('change', function() {
        const type = passwordInputReg.type === 'password' ? 'text' : 'password';
        passwordInputReg.type = type;
        password2InputReg.type = type;
        const label = document.getElementById("togglePasswordLabel");
        label.textContent = label.textContent === "Show Password" ? "Hide Password" : "Show Password";
    });
</script>

</html>