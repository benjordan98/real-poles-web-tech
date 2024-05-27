<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" type="text/css" href="<?= CSS_URL . 'results.css' ?>">
    <title>Your Polls</title>
</head>

<body>
    <?php include("view/menu.php"); ?>
    <div id="noPollContainer">
        <?php if (empty($polls)) : ?>
            <h1>You have not created a poll yet! <a href="<?= BASE_URL . "poll/add" ?>">Add a poll</a></h1>
    </div>
    <div class="main-content">
        <!-- if there are no polls then show a message saying add a poll with a link to the add poll page -->
    <?php endif; ?>
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
<script src="<?= ASSETS_URL . "jquery-3.2.1.min.js" ?>"></script>
<script>
    "use strict";
    $(document).ready(function() {
        let charts = {};
        let lastData = {};

        function get_polls() {
            $.get({
                url: "<?= BASE_URL . "user/results-ajax" ?>",
                success: function(data) {
                    const polls = JSON.parse(data);
                    console.log(polls);
                    polls.forEach(poll => {
                        const pollId = poll.poll_id;
                        const north = poll.north_votes;
                        const south = poll.south_votes;
                        const northOption = poll.north_ans;
                        const southOption = poll.south_ans;
                        const chartId = "chart" + pollId;
                        const currentData = [north, south];

                        if (!arraysEqual(lastData[pollId], currentData)) {
                            const ctx = document.getElementById(chartId).getContext('2d');

                            if (charts[chartId]) {
                                charts[chartId].destroy();
                            }

                            charts[chartId] = new Chart(ctx, {
                                type: 'bar',
                                data: {
                                    labels: [northOption, southOption],
                                    datasets: [{
                                        label: 'Votes',
                                        data: currentData,
                                        backgroundColor: [
                                            '#f38742',
                                            '#39ccf1'
                                        ],
                                        borderColor: [
                                            '#f38742',
                                            '#39ccf1'
                                        ],
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    plugins: {
                                        legend: {
                                            display: false
                                        }
                                    },
                                    scales: {
                                        y: {
                                            beginAtZero: true
                                        }
                                    }
                                }
                            });
                        }
                        lastData[pollId] = currentData.slice();
                    });
                }
            });
        }

        function arraysEqual(arr1, arr2) {
            if (!arr1 || !arr2) return false;
            if (arr1.length !== arr2.length) return false;

            for (let i = 0; i < arr1.length; i++) {
                if (arr1[i] !== arr2[i]) return false;
            }
            return true;
        }

        get_polls();
        setInterval(get_polls, 3000);
    });
</script>

</html>