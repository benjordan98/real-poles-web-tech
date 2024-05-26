<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add a poll!</title>
</head>

<body>
    <?php include("view/menu.php"); ?>
    <!-- <h1>Add a poll!</h1> -->
    <div class="main-container">
        <form action="<?= BASE_URL . "poll/add" ?>" method="POST">
            <div>
                <input type="text" name="question" class="form-control" id="questionInput" placeholder="question" required>
                <label for="questionInput">Question</label>
            </div>
            <div>
                <input type="text" name="north_ans" class="form-control" id="northInput" placeholder="north answer" required>
                <label for="northInput">North answer</label>
            </div>
            <div>
                <input type="text" name="south_ans" class="form-control" id="southInput" placeholder="south answer" required>
                <label for="southInput">South answer</label>
            </div>
            <button type="submit">Add poll</button>
        </form>
    </div>

</body>

</html>