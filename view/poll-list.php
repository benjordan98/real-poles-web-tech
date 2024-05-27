<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="<?= CSS_URL . "allpolls.css" ?>">
    <title>Polls</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                        <form class="vote-form" data-poll-id="<?= $poll['poll_id']; ?>">
                            <input type="hidden" name="poll_id" value="<?= $poll['poll_id']; ?>">
                            <?php if (!PollController::hasUserVoted($poll['poll_id'])) : ?>
                                <button class="btn btnBear" type="button" data-vote="1">
                                    North
                                    <img src="<?= IMAGES_URL . "polar-bear2.svg" ?>" alt="North button">
                                </button>
                                <button class="btn btnPenguin" type="button" data-vote="0">
                                    South
                                    <img src="<?= IMAGES_URL . "penguin-fatter.svg" ?>" alt="South button">
                                </button>
                            <?php endif; ?>
                            <canvas id="chart<?= $poll['poll_id']; ?>" style="display: none;"></canvas>
                        </form>
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
        let charts = {}; // Store chart instances
        let lastVotes = {}; // Store the last votes to check for changes
        // get all public polls
        $.get({
            url: "<?= BASE_URL . "allpolls-ajax" ?>",
            success: function(data) {
                const polls = JSON.parse(data);
                console.log(polls)
                polls.forEach(poll => {
                    const hasVoted = poll.has_voted;
                    if (hasVoted) {
                        const pollId = poll.poll_id;
                        const north = poll.north_votes;
                        const south = poll.south_votes;
                        updateChart(pollId, north, south);
                        lastVotes[pollId] = [north, south];
                    }
                    // const pollId = poll.poll_id;
                    // const north = poll.north_votes;
                    // const south = poll.south_votes;
                    // updateChart(pollId, north, south);
                    // lastVotes[pollId] = [north, south];
                });
            }
        });

        $('.vote-form button').on('click', function() {
            const button = $(this);
            const form = button.closest('.vote-form');
            const pollId = form.data('poll-id');
            const vote = button.data('vote');

            $.ajax({
                url: "<?= BASE_URL . 'poll/vote-ajax' ?>", // Ensure the URL is correct based on your configuration
                type: "POST",
                data: {
                    poll_id: pollId,
                    vote: vote
                },
                dataType: 'json', // Ensuring that jQuery treats the response as JSON
                success: function(response) {
                    if (response.success) {
                        // Update the UI: Remove buttons and show chart
                        form.find('button').hide(); // Hide voting buttons
                        updateChart(pollId, response.north_votes, response.south_votes);
                        $('#chart' + pollId).show(); // Show the chart
                        // Store the updated votes for periodic update checks
                        lastVotes[pollId] = [response.north_votes, response.south_votes];
                    } else if (response.redirect) {
                        // Handle redirection to the login page
                        window.location.href = response.url;
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function(xhr, status, error) {
                    alert('An error occurred: ' + error);
                }
            });
        });


        function updateChart(pollId, northVotes, southVotes) {
            const chartId = 'chart' + pollId;
            const canvas = document.getElementById(chartId);
            if (!canvas) {
                console.error('Canvas element not found for chartId:', chartId);
                return;
            }
            canvas.style.display = 'block'; // Ensure canvas is visible
            const ctx = canvas.getContext('2d');
            if (charts[chartId]) {
                console.log('Destroying existing chart for chartId:', chartId);
                charts[chartId].destroy(); // Destroy existing chart instance if any
            }
            charts[chartId] = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ["North", "South"],
                    datasets: [{
                        label: 'Votes',
                        data: [northVotes, southVotes],
                        backgroundColor: ['#f38742', '#39ccf1'],
                        borderColor: ['#f38742', '#39ccf1'],
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
            console.log('Chart created for chartId:', chartId);
        }

        function fetchUpdates() {
            $.ajax({
                url: "<?= BASE_URL . "polls/get-updates" ?>",
                success: function(data) {
                    // const updates = JSON.parse(data);
                    const updates = data;
                    // console.log(updates);
                    updates.forEach(update => {
                        const pollId = update.poll_id;
                        const northVotes = update.north_votes;
                        const southVotes = update.south_votes;
                        if (lastVotes[pollId] && ($('#chart' + pollId).is(':visible'))) {
                            if (parseInt(lastVotes[pollId][0]) !== northVotes || parseInt(lastVotes[pollId][1]) !== southVotes) {
                                updateChart(pollId, northVotes, southVotes);
                                lastVotes[pollId] = [northVotes, southVotes];
                            }
                        }
                    });
                }
            });
        }

        // Periodic update every 30 seconds
        setInterval(fetchUpdates, 3000);
    });
</script>

</html>