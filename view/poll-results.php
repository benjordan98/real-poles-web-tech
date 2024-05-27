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
        let charts = {}; // Object to store chart instances
        let lastData = {}; // Object to store last known data for each poll

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

                        // Check if data has changed since last update
                        if (!arraysEqual(lastData[pollId], currentData)) {
                            const ctx = document.getElementById(chartId).getContext('2d');

                            // If a chart already exists, destroy it
                            if (charts[chartId]) {
                                charts[chartId].destroy();
                            }

                            // Create a new chart
                            charts[chartId] = new Chart(ctx, {
                                type: 'bar',
                                data: {
                                    labels: [northOption, southOption],
                                    datasets: [{
                                        label: 'Votes',
                                        data: currentData,
                                        backgroundColor: [
                                            '#f38742', // North votes color
                                            '#39ccf1' // South votes color
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

                        // Update last known data
                        lastData[pollId] = currentData.slice();
                    });
                }
            });
        }

        // Compare two arrays for equality
        function arraysEqual(arr1, arr2) {
            if (!arr1 || !arr2) return false;
            if (arr1.length !== arr2.length) return false;

            for (let i = 0; i < arr1.length; i++) {
                if (arr1[i] !== arr2[i]) return false;
            }
            return true;
        }

        // Initial call to populate charts
        get_polls();
        // Set interval to update charts every 5 seconds
        setInterval(get_polls, 5000);
    });


    // let chartIds = [<?php foreach ($polls as $poll) : ?><?= $poll['poll_id'] ?>, <?php endforeach; ?>]
    // let northVotes = [<?php foreach ($polls as $poll) : ?><?= (string)$poll['north_votes'] ?>, <?php endforeach; ?>]
    // let northOptions = [<?php foreach ($polls as $poll) : ?><?= "'" . (string)$poll['north_ans'] . "'" ?>, <?php endforeach; ?>]
    // let southVotes = [<?php foreach ($polls as $poll) : ?><?= $poll['south_votes'] ?>, <?php endforeach; ?>]
    // let southOptions = [<?php foreach ($polls as $poll) : ?><?= "'" . (string)$poll['south_ans'] . "'" ?>, <?php endforeach; ?>]
    // for (let i = 0; i < chartIds.length; i++) {
    //     const id = chartIds[i];
    //     const north = northVotes[i];
    //     const northOption = northOptions[i];
    //     const south = southVotes[i];
    //     const southOption = southOptions[i];
    //     const ctx = document.getElementById("chart" + id).getContext('2d');
    //     const voteChart = new Chart(ctx, {
    //         type: 'bar',
    //         data: {
    //             labels: [northOption, southOption],
    //             datasets: [{
    //                 label: 'Votes',
    //                 data: [north, south], // Replace these numbers with your actual data
    //                 backgroundColor: [
    //                     '#f38742', // North votes color
    //                     '#39ccf1' // South votes color
    //                 ],
    //                 borderColor: [
    //                     '#f38742', // North votes color
    //                     '#39ccf1' // South votes color
    //                 ],
    //                 borderWidth: 1
    //             }]
    //         },
    //         options: {
    //             plugins: {
    //                 legend: {
    //                     display: false // This will hide the legend
    //                 }
    //             },
    //             scales: {
    //                 y: {
    //                     beginAtZero: true // Ensures the scale starts at 0
    //                 }
    //             }
    //         }
    //     });
    // }
</script>

</html>