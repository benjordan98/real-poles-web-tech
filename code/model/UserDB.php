<?php

require_once "DBInit.php";

class UserDB
{
    public static function getUser($username, $password)
    {
        $dbh = DBInit::getInstance();
        $stmt = $dbh->prepare("SELECT user_id, username, password FROM users
            WHERE username = :username");
        $stmt->bindValue(":username", $username);
        $stmt->execute();
        $user = $stmt->fetch();
        if (!$user) {
            return null;
        }
        if (password_verify($password, $user["password"])) {
            unset($user["password"]);
            return $user;
        }
        return null;
    }

    public static function exists($username)
    {
        $dbh = DBInit::getInstance();
        $stmt = $dbh->prepare("SELECT COUNT(user_id) FROM users
            WHERE username = :username");
        $stmt->bindValue(":username", $username);
        $stmt->execute();
        return $stmt->fetchColumn(0) > 0;
    }

    public static function insertUser($username, $password)
    {
        $dbh = DBInit::getInstance();
        $stmt = $dbh->prepare("SELECT MAX(user_id) FROM users");
        $stmt->execute();
        $maxUserId = $stmt->fetchColumn();
        $newUserId = $maxUserId + 1;

        $stmt = $dbh->prepare("INSERT INTO users (user_id, username, password)
            VALUES (:user_id, :username, :password)");
        $stmt->bindValue(":user_id", $newUserId);
        $stmt->bindValue(":username", $username);
        $stmt->bindValue(":password", $password);
        $stmt->bindValue(":password", password_hash($password, PASSWORD_DEFAULT));
        $stmt->execute();
    }
}
