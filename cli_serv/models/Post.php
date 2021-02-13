<?php

class Post implements JsonSerializable
{
    /**
     * @var $author User
     * @var $date DateTime
     */
    public $title, $date, $content, $author, $id;

    public function __construct()
    {
        $this->author = UserData::getUser($this->user_id);
        try {
            $this->date = new DateTime($this->created_at);
        } catch (Exception $e) {
            die('Error has occured rip');
        }
    }

    public function stringDate()
    {
        return $this->date->format('F j, Y, g:i a');
    }

    public function jsonSerialize()
    {
        $this->date = $this->stringDate();
        return $this;
    }

    public function comments()  // gets comments
    {
        $sql = 'SELECT * FROM comments WHERE post_id = :postId ORDER BY date DESC';
        $stmt = db::db()->prepare($sql);
        $stmt->bindParam(':postId', $this->id);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Comment');
        $stmt->execute();
        return $stmt->fetchAll();
    }

}