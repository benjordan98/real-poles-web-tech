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
                <h1>Log in</h1>
                <div>
                    <label for="usernameInput">Username</label>
                    <input type="text" name="username" class="form-control" id="usernameInput" placeholder="username" pattern="[a-zA-Z0-9]+">
                </div>
                <div>
                    <label for="passwordInput">Password</label>
                    <input type="password" name="password" class="form-control" id="passwordInput" placeholder="password" required>
                    <!-- Checkbox to toggle password visibility -->
                </div>
                <div>
                    <input type="checkbox" id="togglePassword">
                    <label id="togglePasswordLabel" for="togglePassword">Show Password</label>
                </div>
                <button type="submit">Log in</button>
            </form>
        </main>
    </div>

    <!-- Inline JavaScript for handling password visibility toggle -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const usernameInput = document.getElementById("usernameInput");
            const form = document.querySelector('form'); // Assuming only one form on the page

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
                // Check the validity again on submit and prevent submission if there are any validation errors
                if (!usernameInput.checkValidity()) {
                    event.preventDefault(); // Stop the form from submitting
                    usernameInput.reportValidity(); // Show the validity error if not already shown
                }
            });

            const togglePassword = document.querySelector('#togglePassword');
            const passwordInput = document.querySelector('#passwordInput');

            togglePassword.addEventListener('change', function() {
                // Toggle the type attribute
                const type = passwordInput.type === 'password' ? 'text' : 'password';
                passwordInput.type = type;
                // Update the label of the checkbox
                const label = document.getElementById("togglePasswordLabel");
                label.textContent = label.textContent === "Show Password" ? "Hide Password" : "Show Password";
            });
        });
    </script>
</body>

</html>