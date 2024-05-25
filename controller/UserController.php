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

    public static function register()
    {
        $rules = [
            "username" => [
                "filter" => FILTER_SANITIZE_SPECIAL_CHARS,
                "options" => function ($value) {
                    return ctype_alnum($value);
                }
            ],
            "password" => [
                "filter" => FILTER_SANITIZE_SPECIAL_CHARS
            ],
            "password2" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS]
        ];

        $data = filter_input_array(INPUT_POST, $rules);

        $errors = [];

        if (empty($data["username"])) {
            $errors["username"] = "Username is mandatory.";
        } else if (UserDB::exists($data["username"])) {
            $errors["username"] = "Username already exists.";
        }

        if (empty($data["password"])) {
            $errors["password"] = "Password is mandatory.";
        } else if (empty($data["password2"])) {
            $errors["password2"] = "Password confirmation is mandatory.";
        } else if ($data["password"] !== $data["password2"]) {
            $errors["password2"] = "Passwords do not match.";
        }

        if (!empty($errors)) {
            self::registerForm($errors);
        } else {
            UserDB::insertUser($data["username"], $data["password"]);
            self::login();
        }
    }

    public static function registerForm($errors)
    {
        ViewHelper::render("view/user-register.php", $errors);
    }
}
