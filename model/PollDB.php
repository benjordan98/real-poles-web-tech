<?php

class PollDB
{
    public static function getAllPolls()
    {
        $dbh = DBInit::getInstance();
        $stmt = $dbh->prepare("SELECT p.poll_id, p.question, p.north_ans, p.south_ans, u.username, SUM(v.vote) AS north_votes, COUNT(v.vote) - SUM(v.vote) AS south_votes
                       FROM polls p
                       LEFT JOIN votes v ON p.poll_id = v.poll_id
                       LEFT JOIN users u ON p.created_by = u.user_id
                       GROUP BY p.poll_id, p.question");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function getAllOtherPolls($user_id)
    {
        $dbh = DBInit::getInstance();
        $stmt = $dbh->prepare("SELECT p.poll_id, p.question, p.north_ans, p.south_ans, u.username, SUM(v.vote) AS north_votes, COUNT(v.vote) - SUM(v.vote) AS south_votes
                       FROM polls p
                       LEFT JOIN votes v ON p.poll_id = v.poll_id
                       LEFT JOIN users u ON p.created_by = u.user_id
                          WHERE p.created_by != :user_id
                       GROUP BY p.poll_id, p.question");
        $stmt->bindValue(":user_id", $user_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function getAllUserPolls($user_id)
    {
        $dbh = DBInit::getInstance();
        $stmt = $dbh->prepare("SELECT p.poll_id, p.question, p.north_ans, p.south_ans, SUM(v.vote) AS north_votes, COUNT(v.vote) - SUM(v.vote) AS south_votes
                               FROM polls p
                               LEFT JOIN votes v ON p.poll_id = v.poll_id
                               WHERE p.created_by = :user_id
                               GROUP BY p.poll_id, p.question");
        $stmt->bindValue(":user_id", $user_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function insertPoll($question, $north_ans, $south_ans, $user_id)
    {
        // get new poll id
        $dbh = DBInit::getInstance();
        $stmt = $dbh->prepare("SELECT MAX(poll_id) FROM polls");
        $stmt->execute();
        $maxPollId = $stmt->fetchColumn();
        $newPollId = $maxPollId + 1;

        $dbh = DBInit::getInstance();
        $stmt = $dbh->prepare("INSERT INTO polls (poll_id, question, north_ans, south_ans, created_by) VALUES (:poll_id, :question, :north_ans, :south_ans, :user_id)");
        $stmt->bindValue(":question", $question);
        $stmt->bindValue(":poll_id", $newPollId);
        $stmt->bindValue(":user_id", $user_id);
        $stmt->bindValue(":north_ans", $north_ans);
        $stmt->bindValue(":south_ans", $south_ans);
        $stmt->execute();
    }

    public static function hasUserVoted($poll_id, $user_id)
    {
        $dbh = DBInit::getInstance();
        $stmt = $dbh->prepare("SELECT COUNT(*) FROM votes WHERE poll_id = :poll_id AND user_id = :user_id");
        $stmt->bindValue(":poll_id", $poll_id);
        $stmt->bindValue(":user_id", $user_id);
        $stmt->execute();
        return $stmt->fetchColumn(0) > 0;
    }

    public static function isMyPoll($poll_id, $user_id)
    {
        $dbh = DBInit::getInstance();
        $stmt = $dbh->prepare("SELECT COUNT(*) FROM polls WHERE poll_id = :poll_id AND created_by = :user_id");
        $stmt->bindValue(":poll_id", $poll_id);
        $stmt->bindValue(":user_id", $user_id);
        $stmt->execute();
        return $stmt->fetchColumn(0) > 0;
    }

    public static function insertVote($poll_id, $vote, $user_id)
    {
        $dbh = DBInit::getInstance();
        $stmt = $dbh->prepare("SELECT MAX(vote_id) FROM votes");
        $stmt->execute();
        $maxVoteId = $stmt->fetchColumn();
        $newVoteId = $maxVoteId + 1;

        echo "inserting vote";
        $dbh = DBInit::getInstance();
        echo $poll_id;
        $stmt = $dbh->prepare("INSERT INTO votes (vote_id, poll_id, vote, user_id) VALUES (:vote_id, :poll_id, :vote, :user_id)");
        $stmt->bindValue(":vote_id", $newVoteId);
        $stmt->bindValue(":poll_id", $poll_id);
        $stmt->bindValue(":vote", $vote);
        $stmt->bindValue(":user_id", $user_id);
        $stmt->execute();
    }
}
