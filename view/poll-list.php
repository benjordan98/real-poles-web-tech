<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Polls</title>
</head>

<body>
    <?php include("view/menu.php"); ?>
    <!-- get all polls from all users -->
    <h1>Polls</h1>
    <!-- <table>
        <tr>
            <th>Poll Question</th>
            <th>User</th>
            <th>North Answer</th>
            <th>North Votes</th>
            <th>South Answer</th>
            <th>South Votes</th>
        </tr>
        <?php foreach ($polls as $poll) : ?>
            <tr>
                <td>
                    <?= $poll["question"] ?>
                </td>
                <td>
                    <?= $poll['username'] ?>
                </td>
                <td> <?= $poll["north_ans"] ?> </td>
                <td><?= $poll["north_votes"] ?></td>
                <td><?= $poll["south_votes"] ?></td>
            </tr>
        <?php endforeach; ?>
    </table> -->

    <div class="container">
        <div class="row">
            <?php foreach ($polls as $poll) : ?>
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?= $poll["question"] ?></h5>
                            <form method="post" action="<?= BASE_URL . "poll/vote" ?>">
                                <input type="hidden" name="poll_id" value="<?= $poll['poll_id']; ?>">
                                <p class="card-text">North votes: <?= $poll["north_votes"] ?> South votes: <?= $poll["south_votes"] ?></p>
                                <button class="btn btn-primary" type="submit" name="vote" value="1">
                                    <img src="<?= IMAGES_URL . "north_button.png" ?>" alt="fuck shit" style="width: 100px; height: 40px;">
                                </button>
                                <button class="btn btn-primary" type="submit" name="vote" value="0">
                                    <img src="<?= IMAGES_URL . "south_button.png" ?>" alt="fuck" style="width: 100px; height: 40px;">
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>


</body>

</html>