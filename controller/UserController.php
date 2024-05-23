<?php

require_once("model/UserDB.php");
require_once("ViewHelper.php");
require_once("model/User.php");

class UserController
{
    public static function login()
    {
        $rules = [
            "username" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "password" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS]
        ];

        $data = filter_input_array(INPUT_POST, $rules);
        $user = UserDB::getUser($data["username"], $data["password"]);
        $errorMessage =  empty($data["username"]) || empty($data["password"]) || $user == null ? "Invalid username or password." : "";

        if (empty($errorMessage)) {
            User::login($user);

            $vars = [
                "username" => $data["username"],
                "password" => $data["password"]
            ];

            if (User::isAdmin()) {
                ViewHelper::redirect(BASE_URL . "results");
            } else {
                ViewHelper::redirect(BASE_URL . "results");
            }
            // ViewHelper::render("view/user-login-success.php", $vars);
        } else {
            ViewHelper::render("view/user-login.php", [
                "errorMessage" => $errorMessage,
            ]);
        }
    }

    public static function loginForm($errors)
    {
        ViewHelper::render("view/user-login.php", $errors);
    }
}
