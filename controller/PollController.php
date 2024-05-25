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
}
