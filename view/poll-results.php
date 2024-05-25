<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Polls</title>
</head>

<body>
    <?php include("view/menu.php"); ?>
    <h1>Your Polls!</h1>
    <table>
        <tr>
            <th>Poll Question</th>
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
                <td> <?= $poll["north_ans"] ?> </td>
                <td><?= $poll["north_votes"] ?></td>
                <td> <?= $poll["south_ans"] ?> </td>
                <td><?= $poll["south_votes"] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>

</html>