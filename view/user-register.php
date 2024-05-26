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
    <div class="register-container"> <!-- Added container to wrap the form -->
        <main class="form-signup">
            <h1>Sign-up</h1>
            <form action="<?= BASE_URL . "user/register" ?>" method="POST">
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
    const password2Input = document.querySelector('#password2Input');

    togglePassword.addEventListener('change', function() {
        // Toggle the type attribute
        const type = passwordInput.type === 'password' ? 'text' : 'password';
        passwordInput.type = type;
        password2Input.type = type;
        // Toggle the label text
        this.nextSibling.textContent = (type === 'password') ? "Show Password" : "Hide Password";
    });
</script>

</html>