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
        const form = document.querySelector('form');

        function checkQuestion() {
            const questionPattern = /\?$/;
            if (!questionPattern.test(questionInput.value)) {
                questionInput.setCustomValidity("Remember to enter a question that ends with a question mark!");
            } else {
                questionInput.setCustomValidity("");
            }
            questionInput.reportValidity();
        }

        function checkSingleWord(inputElement) {
            const wordPattern = /^\S+$/;
            if (!wordPattern.test(inputElement.value)) {
                inputElement.setCustomValidity("Please enter only one word.");
            } else {
                inputElement.setCustomValidity("");
            }
            inputElement.reportValidity();
        }

        questionInput.addEventListener('input', checkQuestion);
        northInput.addEventListener('input', function() {
            checkSingleWord(this);
        });
        southInput.addEventListener('input', function() {
            checkSingleWord(this);
        });

        form.addEventListener('submit', function(event) {
            checkQuestion();
            checkSingleWord(northInput);
            checkSingleWord(southInput);

            // Prevent form submission if any inputs are invalid
            if (!questionInput.checkValidity() || !northInput.checkValidity() || !southInput.checkValidity()) {
                event.preventDefault();
                const firstInvalid = form.querySelector(':invalid');
                firstInvalid && firstInvalid.focus();
            }
        });
    });
</script>

</html>