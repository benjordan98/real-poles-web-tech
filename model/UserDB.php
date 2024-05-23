<?php

require_once "DBInit.php";

class UserDB
{
    public static function getUser($username, $password)
    {
        $dbh = DBInit::getInstance();
        // print list of db tables to check its working
        $stmt = $dbh->query("SHOW TABLES");
        $tables = $stmt->fetchAll();
        print_r($tables);
        $stmt = $dbh->prepare("SELECT user_id, username, password FROM users
            WHERE username = :username");
        // $stmt = $dbh->prepare("SELECT * FROM users");
        $stmt->bindValue(":username", $username);
        // print statement
        $stmt->execute();
        $user = $stmt->fetch();
        print_r($user);
        // for now no hashing of password until registration is implemented
        if ($password == $user["password"]) {
            echo "password verified";
            unset($user["password"]);
            return $user;
        }
        // if (password_verify($password, $user["password"])) {
        //     echo "password verified";
        //     unset($user["password"]);
        //     return $user;
        // }
        echo "password not verified";
        return null;
    }
}
