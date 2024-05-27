<?php

class User
{
    public static function login($user)
    {
        $_SESSION["user_id"] = $user["user_id"];
        $_SESSION["username"] = $user["username"];
    }

    public static function logout()
    {
        session_destroy();
    }

    public static function isLoggedIn()
    {
        return isset($_SESSION["user_id"]);
    }

    public static function isAdmin()
    {
        return isset($_SESSION["user_id"]) && $_SESSION["user_id"] == 1;
    }
}
