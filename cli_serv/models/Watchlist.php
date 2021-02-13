<?php


class Watchlist
{
    private $user_id, $post_id;

    /**
     * @var Post
     */
    public $post;

    public function __construct()       // gets the specific post from the db
    {
        $sql = "SELECT * FROM posts WHERE id = $this->post_id";

        $stmt = db::db()->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Post');
        $this->post = $stmt->fetch();
    }
}