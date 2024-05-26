<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="<?= CSS_URL . "allpolls.css" ?>">
    <title>Polls</title>
</head>

<body>
    <?php include("view/menu.php"); ?>
    <div class="main-content">
        <!-- <h1>Polls</h1> -->
        <div class="card-container">
            <?php foreach ($polls as $poll) : ?>
                <div class="card">
                    <div class="card-body">
                        <p class="card-title">
                            <span><?= $poll["question"] ?></span>
                            <span class="north-ans"><?= $poll["north_ans"] ?></span>
                            <span class="south-ans"><?= $poll["south_ans"] ?></span>
                        </p>
                        <form method="post" action="<?= BASE_URL . "poll/vote" ?>">
                            <input type="hidden" name="poll_id" value="<?= $poll['poll_id']; ?>">
                            <?php if (PollController::hasUserVoted($poll['poll_id'])) : ?>
                                <p class="card-text">North votes: <?= $poll["north_votes"] ?> South votes: <?= $poll["south_votes"] ?></p>
                            <?php endif; ?>
                            <!-- only show the buttons if the user has not voted on it already -->
                            <?php if (!PollController::hasUserVoted($poll['poll_id'])) : ?>
                                <button class="btn btn-primary" type="submit" name="vote" value="1">
                                    <img src="<?= IMAGES_URL . "north_button.png" ?>" alt="North button" style="width: 100px; height: 40px;">
                                </button>
                                <button class="btn btn-primary" type="submit" name="vote" value="0">
                                    <img src="<?= IMAGES_URL . "south_button.png" ?>" alt="South button" style="width: 100px; height: 40px;">
                                </button>
                            <?php endif; ?>
                            <!-- <button class="btn btn-primary" type="submit" name="vote" value="1">
                                <img src="<?= IMAGES_URL . "north_button.png" ?>" alt="North button" style="width: 100px; height: 40px;">
                            </button>
                            <button class="btn btn-primary" type="submit" name="vote" value="0">
                                <img src="<?= IMAGES_URL . "south_button.png" ?>" alt="South button" style="width: 100px; height: 40px;">
                            </button> -->
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>

</html>