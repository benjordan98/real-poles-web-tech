<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Polls</title>
</head>

<body>
    <h1>Your Polls!</h1>
    <table>
        <tr>
            <th>Poll Question</th>
            <th>Yes Votes</th>
            <th>No Votes</th>
        </tr>
        <?php foreach ($polls as $poll) : ?>
            <tr>
                <td>
                    <!-- <a href="<?= BASE_URL . "poll/" . $poll["poll_id"] ?>">
                        <?= $poll["question"] ?>
                    </a> -->
                    <?= $poll["question"] ?>
                </td>
                <td><?= $poll["yes_votes"] ?></td>
                <td><?= $poll["no_votes"] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>

</html>