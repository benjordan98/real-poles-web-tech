<?php
session_start();

require_once("controller/PollController.php");
require_once("controller/UserController.php");

define("BASE_URL", $_SERVER["SCRIPT_NAME"] . "/");
define("CSS_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "assets/styles/");
define("IMAGES_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "assets/images/");


$path = isset($_SERVER["PATH_INFO"]) ? trim($_SERVER["PATH_INFO"], "/") : "";

$urls = [
    "user/login" => function () {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            echo "POST";
            UserController::login();
        } else {
            echo "show login form";
            UserController::loginForm(array());
        }
    },
    "user/results" => function () {
        PollController::showResults();
    },
];

try {
    if (isset($urls[$path])) {
        $urls[$path]();
    } else {
        echo "No controller for '$path'";
    }
} catch (Exception $e) {
    // echo "An error occurred: <pre>$e</pre>";
    // 404 or 400 message?
    ViewHelper::error404($e);
}
