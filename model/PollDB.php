<?php

class PollDB
{
    public static function getAllPolls()
    {
        $dbh = DBInit::getInstance();
        $stmt = $dbh->prepare("SELECT p.poll_id, p.question, u.username, SUM(v.vote) AS yes_votes, COUNT(v.vote) - SUM(v.vote) AS no_votes
                       FROM polls p
                       LEFT JOIN votes v ON p.poll_id = v.poll_id
                       LEFT JOIN users u ON p.created_by = u.user_id
                       GROUP BY p.poll_id, p.question");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function getAllUserPolls($user_id)
    {
        $dbh = DBInit::getInstance();
        $stmt = $dbh->prepare("SELECT p.poll_id, p.question, SUM(v.vote) AS yes_votes, COUNT(v.vote) - SUM(v.vote) AS no_votes
                               FROM polls p
                               LEFT JOIN votes v ON p.poll_id = v.poll_id
                               WHERE p.created_by = :user_id
                               GROUP BY p.poll_id, p.question");
        $stmt->bindValue(":user_id", $user_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
