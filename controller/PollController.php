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

    public static function showAllPolls()
    {
        $polls = PollDB::getAllPolls();
        ViewHelper::render("view/poll-list.php", ["polls" => $polls]);
    }

    public static function addPoll()
    {
        $validData = isset($_POST["question"]) && isset($_POST["north_ans"]) && isset($_POST["south_ans"]);
        if ($validData) {
            $question = $_POST["question"];
            $north_ans = $_POST["north_ans"];
            $south_ans = $_POST["south_ans"];
            PollDB::insertPoll($question, $north_ans, $south_ans, $_SESSION["user_id"]);
            ViewHelper::redirect(BASE_URL . "results");
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
        return PollDB::hasUserVoted($poll_id, $_SESSION["user_id"]);
    }

    public static function vote()
    {
        if (!User::isLoggedIn()) {
            ViewHelper::redirect(BASE_URL . "user/login");
            echo "You need to be logged in to vote.";
            return;
        }
        if (self::hasUserVoted($_POST["poll_id"])) {
            self::showAllPolls(["errorMessage" => "You have already voted."]);
            echo "You have already voted.";
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
}
