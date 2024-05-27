<?php

require_once("model/PollDB.php");
require_once("ViewHelper.php");
require_once("model/User.php");

class PollController
{

    public static function showResults()
    {
        $polls = PollDB::getAllUserPolls($_SESSION["user_id"]);
        ViewHelper::render("view/poll-results.php", ["polls" => $polls]);
    }

    public static function showResultsAjax()
    {
        $polls = PollDB::getAllUserPolls($_SESSION["user_id"]);
        echo json_encode($polls);
    }

    public static function showAllPolls()
    {
        if (User::isLoggedIn()) {
            $polls = PollDB::getAllOtherPolls($_SESSION["user_id"]);
        } else {
            $polls = PollDB::getAllPolls();
        }
        ViewHelper::render("view/poll-list.php", ["polls" => $polls]);
    }

    public static function showAllPollsAjax()
    {
        if (User::isLoggedIn()) {
            $polls = PollDB::getAllOtherPollsAjax($_SESSION["user_id"]);
            echo json_encode($polls);
        } else {
            $polls = PollDB::getAllPolls();
            echo json_encode($polls);
        }
    }

    public static function deletePoll()
    {
        $validData = isset($_POST["poll_id"]);
        if ($validData) {
            PollDB::deletePoll($_POST["poll_id"]);
            ViewHelper::redirect(BASE_URL . "user/results");
        } else {
            self::showAllPolls(["errorMessage" => "Invalid data."]);
        }
    }

    public static function addPoll()
    {
        $validData = isset($_POST["question"]) && isset($_POST["north_ans"]) && isset($_POST["south_ans"]);
        if ($validData) {
            $question = $_POST["question"];
            $north_ans = $_POST["north_ans"];
            $south_ans = $_POST["south_ans"];
            PollDB::insertPoll($question, $north_ans, $south_ans, $_SESSION["user_id"]);
            ViewHelper::redirect(BASE_URL . "user/results");
        } else {
            self::addPollForm(["errorMessage" => "Invalid data."]);
        }
    }

    public static function addPollForm($variables = array())
    {
        ViewHelper::render("view/poll-add.php", $variables);
    }

    public static function hasUserVoted($poll_id)
    {
        if (!User::isLoggedIn()) {
            return false;
        }
        return PollDB::hasUserVoted($poll_id, $_SESSION["user_id"]);
    }

    public static function vote()
    {
        if (!User::isLoggedIn()) {
            ViewHelper::render("view/user-login.php", ["errorMessage" => "You need to be logged in to vote."]);
            return;
        }
        if (self::hasUserVoted($_POST["poll_id"])) {
            self::showAllPolls(["errorMessage" => "You have already voted."]);
            return;
        }
        $validData = isset($_POST["poll_id"]) && isset($_POST["vote"]);
        if ($validData) {
            $poll_id = $_POST["poll_id"];
            $vote = $_POST["vote"];
            PollDB::insertVote($poll_id, $vote, $_SESSION["user_id"]);
            ViewHelper::redirect(BASE_URL . "allpolls");
        } else {
            self::showAllPolls(["errorMessage" => "Invalid data."]);
        }
    }

    public static function voteAjax()
    {
        header('Content-Type: application/json'); // Set the header to ensure response is treated as JSON
        if (!User::isLoggedIn()) {
            $loginUrl = BASE_URL . "user/login" . "?error=" . urlencode("You need to be logged in to vote.");
            echo json_encode(["success" => false, "redirect" => true, "url" => $loginUrl]);
            return;
        }


        if (self::hasUserVoted($_POST["poll_id"])) {
            echo json_encode(["success" => false, "message" => "You have already voted."]);
            return;
        }

        $validData = isset($_POST["poll_id"]) && isset($_POST["vote"]);
        if ($validData) {
            $poll_id = $_POST["poll_id"];
            $vote = $_POST["vote"];
            PollDB::insertVote($poll_id, $vote, $_SESSION["user_id"]);
            $votes = PollDB::getVotes($poll_id);
            echo json_encode([
                "success" => true,
                "north_votes" => $votes['north_votes'],
                "south_votes" => $votes['south_votes'],
                "poll_id" => $poll_id
            ]);
        } else {
            echo json_encode(["success" => false, "message" => "Invalid data."]);
        }
    }

    public static function getUpdates()
    {
        header('Content-Type: application/json');
        $polls = PollDB::getAllPolls();
        $updates = [];
        foreach ($polls as $poll) {
            $votes = PollDB::getVotes($poll["poll_id"]);
            $updates[] = [
                "poll_id" => $poll["poll_id"],
                "north_votes" => $votes["north_votes"],
                "south_votes" => $votes["south_votes"]
            ];
        }
        echo json_encode($updates);
    }
}
