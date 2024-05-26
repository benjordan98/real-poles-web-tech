<?php
session_start();

require_once("controller/PollController.php");
require_once("controller/UserController.php");

define("BASE_URL", $_SERVER["SCRIPT_NAME"] . "/");
define("CSS_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "assets/css/");
define("IMAGES_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "assets/images/");


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
    "results" => function () {
        // check if user is logged in
        if (!User::isLoggedIn()) {
            ViewHelper::redirect(BASE_URL . "user/login");
            return;
        }
        PollController::showResults();
    },
    "allpolls" => function () {
        PollController::showAllPolls();
    },
    "poll/add" => function () {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            PollController::addPoll();
        } else {
            PollController::addPollForm(array());
        }
    },
    "poll/vote" => function () {
        PollController::vote();
    }
];

try {
    if (isset($urls[$path])) {
        $urls[$path]();
    } else {
        echo "No controller for '$path'";
    }
} catch (Exception $e) {
    echo "An error occurred: <pre>$e</pre>";
    // 404 or 400 message?
    ViewHelper::error404($e);
}
