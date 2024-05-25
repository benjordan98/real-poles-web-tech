<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign in</title>
    <!-- <link rel="stylesheet" type="text/css" href="<?= CSS_URL . "register.css" ?>"> -->
</head>

<body>
    <?php include("view/menu.php"); ?>
    <h1>Sign-up</h1>
    <form action="<?= BASE_URL . "user/register" ?>" method="POST">
        <div>
            <input type="text" name="username" class="form-control" id="usernameInput" placeholder="username" pattern="[a-zA-Z0-9]+" required>
            <label for="usernameInput">Username</label>
        </div>
        <div>
            <input type="password" name="password" class="form-control" id="passwordInput" placeholder="password" required>
            <label for="passwordInput">Password</label>
        </div>
        <div>
            <input type="password" name="password2" class="form-control" id="password2Input" placeholder="password" required>
            <label for="password2Input">Repeat password</label>
        </div>
        <button type="submit">Sign up</button>
    </form>
</body>
<script>
    // link this up with the form validation
    // TODO: what does this do? How does it work?
    document.getElementById("usernameInput").addEventListener("input", function() {
        if (this.validity.patternMismatch) {
            this.setCustomValidity("Username can only contain letters and numbers.");
        } else {
            this.setCustomValidity("");
        }
    });
    document.getElementById("passwordInput").addEventListener("input", function() {
        this.setCustomValidity(this.validity.patternMismatch ? "Password must be at least 8 characters long and contain at least one number, one lowercase letter and one uppercase letter." : "");
    });
    document.getElementById("password2Input").addEventListener("input", function() {
        this.setCustomValidity(this.validity.valueMismatch ? "Passwords do not match." : "");
    });
</script>

</html>