<?php

class PollDB
{

    public static function getAll()
    {
        $dbh = DBInit::getInstance();
        $stmt = $dbh->prepare("SELECT poll_id, question FROM polls");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function getAllUserPolls($user_id)
    {
        $dbh = DBInit::getInstance();
        $stmt = $dbh->prepare("SELECT poll_id, question FROM polls WHERE user_id = :user_id");
        $stmt->bindValue(":user_id", $user_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
