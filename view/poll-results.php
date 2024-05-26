<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="<?= CSS_URL . "results.css" ?>">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Your Polls</title>
</head>

<body>
    <?php include("view/menu.php"); ?>
    <div class="main-content">
        <!-- <h1>Polls</h1> -->
        <div class="card-container">
            <?php foreach ($polls as $poll) : ?>
                <div class="card">
                    <div class="card-body">
                        <div class="delete-btn-container">
                            <form method="post" action="<?= BASE_URL . "poll/delete" ?>">
                                <input type="hidden" name="poll_id" value="<?= $poll['poll_id']; ?>">
                                <button type="submit" class="delete-btn">X</button>
                            </form>
                        </div>
                        <p class="card-title">
                            <span><?= $poll["question"] ?></span>
                            <span class="north-ans"><?= $poll["north_ans"] ?></span>
                            <span class="south-ans"><?= $poll["south_ans"] ?></span>
                        </p>
                        <canvas id="<?= "chart" . $poll['poll_id'] ?>"></canvas>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
<script>
    let chartIds = [<?php foreach ($polls as $poll) : ?><?= $poll['poll_id'] ?>, <?php endforeach; ?>]
    let northVotes = [<?php foreach ($polls as $poll) : ?><?= (string)$poll['north_votes'] ?>, <?php endforeach; ?>]
    let northOptions = [<?php foreach ($polls as $poll) : ?><?= "'" . (string)$poll['north_ans'] . "'" ?>, <?php endforeach; ?>]
    let southVotes = [<?php foreach ($polls as $poll) : ?><?= $poll['south_votes'] ?>, <?php endforeach; ?>]
    let southOptions = [<?php foreach ($polls as $poll) : ?><?= "'" . (string)$poll['south_ans'] . "'" ?>, <?php endforeach; ?>]
    for (let i = 0; i < chartIds.length; i++) {
        const id = chartIds[i];
        const north = northVotes[i];
        const northOption = northOptions[i];
        const south = southVotes[i];
        const southOption = southOptions[i];
        const ctx = document.getElementById("chart" + id).getContext('2d');
        const voteChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [northOption, southOption],
                datasets: [{
                    label: 'Votes',
                    data: [north, south], // Replace these numbers with your actual data
                    backgroundColor: [
                        '#f38742', // North votes color
                        '#39ccf1' // South votes color
                    ],
                    borderColor: [
                        '#f38742', // North votes color
                        '#39ccf1' // South votes color
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false // This will hide the legend
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true // Ensures the scale starts at 0
                    }
                }
            }
        });
    }
</script>

</html>