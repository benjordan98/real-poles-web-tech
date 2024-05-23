<?php

class PollController
{

    public static function showResults()
    {
        $polls = PollDB::getAllUserPolls($_SESSION["user_id"]);
        ViewHelper::render("view/poll-results.php", ["polls" => $polls]);
    }
}
