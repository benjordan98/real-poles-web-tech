<?php
session_start();

require_once("controller/PollController.php");
require_once("controller/UserController.php");

define("BASE_URL", $_SERVER["SCRIPT_NAME"] . "/");
define("CSS_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "assets/css/");
define("IMAGES_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "assets/images/");
define("ASSETS_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "assets/");


$path = isset($_SERVER["PATH_INFO"]) ? trim($_SERVER["PATH_INFO"], "/") : "";

$urls = [
    "user/login" => function () {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            UserController::login();
        } else {
            UserController::loginForm(array());
        }
    },
    "user/register" => function () {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            UserController::register();
        } else {
            UserController::registerForm(array());
        }
    },
    "user/logout" => function () {
        UserController::logout();
    },
    "user/results" => function () {
        if (!User::isLoggedIn()) {
            ViewHelper::redirect(BASE_URL . "user/login");
            return;
        }
        PollController::showResults();
    },
    "user/results-ajax" => function () {
        if (!User::isLoggedIn()) {
            ViewHelper::redirect(BASE_URL . "user/login");
            return;
        }
        PollController::showResultsAjax();
    },
    "allpolls" => function () {
        PollController::showAllPolls();
    },
    "allpolls-ajax" => function () {
        PollController::showAllPollsAjax();
    },
    "poll/add" => function () {
        if (!User::isLoggedIn()) {
            ViewHelper::redirect(BASE_URL . "user/login");
            return;
        }
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            PollController::addPoll();
        } else {
            PollController::addPollForm(array());
        }
    },
    "poll/vote" => function () {
        PollController::vote();
    },
    "poll/vote-ajax" => function () {
        PollController::voteAjax();
    },
    "polls/get-updates" => function () {
        PollController::getUpdates();
    },
    "poll/delete" => function () {
        PollController::deletePoll();
    },
];

try {
    if (isset($urls[$path])) {
        $urls[$path]();
    } else {
        ViewHelper::error404();
    }
} catch (Exception $e) {
    echo "An error occurred: <pre>$e</pre>";
    ViewHelper::error404($e);
}
