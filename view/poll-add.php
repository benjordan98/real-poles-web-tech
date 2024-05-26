<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="<?= CSS_URL . "add.css" ?>">
    <title>Add a poll!</title>
</head>

<body>
    <?php include("view/menu.php"); ?>
    <!-- <h1>Add a poll!</h1> -->
    <div class="add-container">
        <main class="form-add">
            <form action="<?= BASE_URL . "poll/add" ?>" method="POST">
                <div>
                    <label for="questionInput">Question</label>
                    <textarea name="question" class="form-control" id="questionInput" placeholder="Enter your question here..." required rows="4"></textarea>
                </div>
                <div>
                    <label for="northInput">North answer</label>
                    <input type="text" name="north_ans" class="form-control" id="northInput" placeholder="north answer" required>
                </div>
                <div>
                    <label for="southInput">South answer</label>
                    <input type="text" name="south_ans" class="form-control" id="southInput" placeholder="south answer" required>
                </div>
                <button type="submit">Add poll</button>
            </form>
        </main>
    </div>
</body>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const questionInput = document.getElementById("questionInput");
        const northInput = document.getElementById("northInput");
        const southInput = document.getElementById("southInput");
        const form = document.querySelector('form'); // Assuming only one form on the page

        // Function to check if the question ends with a question mark
        function checkQuestion() {
            const questionPattern = /\?$/;
            if (!questionPattern.test(questionInput.value)) {
                questionInput.setCustomValidity("Remember to enter a question that ends with a question mark!");
            } else {
                questionInput.setCustomValidity("");
            }
            questionInput.reportValidity();
        }

        // Function to check for single-word input
        function checkSingleWord(inputElement) {
            const wordPattern = /^\S+$/;
            if (!wordPattern.test(inputElement.value)) {
                inputElement.setCustomValidity("Please enter only one word.");
            } else {
                inputElement.setCustomValidity("");
            }
            inputElement.reportValidity();
        }

        // Event listeners for input validation
        questionInput.addEventListener('input', checkQuestion);
        northInput.addEventListener('input', function() {
            checkSingleWord(this);
        });
        southInput.addEventListener('input', function() {
            checkSingleWord(this);
        });

        // Event listener to prevent form submission if any input is invalid
        form.addEventListener('submit', function(event) {
            // Re-validate all fields to ensure conditions are met
            checkQuestion(); // Check if the question ends with a question mark
            checkSingleWord(northInput); // Check if north answer is one word
            checkSingleWord(southInput); // Check if south answer is one word

            // Prevent form submission if any inputs are invalid
            if (!questionInput.checkValidity() || !northInput.checkValidity() || !southInput.checkValidity()) {
                event.preventDefault(); // Stop form from submitting
                // You can add additional actions here, like focusing the first invalid input
                const firstInvalid = form.querySelector(':invalid');
                firstInvalid && firstInvalid.focus();
            }
        });
    });
</script>

</html>