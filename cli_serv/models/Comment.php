<?php


class Comment
{
    /**
     * @var $author User
     * @var $date DateTime
     */
    public $date, $body, $author, $id;

    public function __construct()
    {
        $this->author = UserData::getUser($this->user_id);
        try {
            $this->date = new DateTime($this->date);
        } catch (Exception $e) {
            die('Error has occured rip');
        }
    }

    public function stringDate()
    {
        return $this->date->format('F j, Y, g:i a');
    }
}