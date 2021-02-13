<?php


class User implements JsonSerializable
{
    public $id, $email, $password, $name;

    public function isWatched($postid)
    {
        $sql = "SELECT * FROM watchlist WHERE user_id = $this->id AND post_id = $postid";

        $ret = db::db()->query($sql)->fetch();
        return !empty($ret);
    }

    /**
     * @return Watchlist[]
     */
    public function watchlist()
    {
        $sql = "SELECT * FROM watchlist WHERE user_id = $this->id";

        $stmt = db::db()->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Watchlist');
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function jsonSerialize()
    {
        unset($this->password);
        return $this;
    }

    public function watchPost($postId)   // adds a post to the watch list
    {
        $sql = "INSERT INTO watchlist VALUES (:user_id, :post_id)";

        $stmt = db::db()->prepare($sql);
        $stmt->bindParam(':user_id', $this->id);
        $stmt->bindParam(':post_id', $postId);

        $stmt->execute();
    }

    public function unwatchPost($postId)   // removes a post from the watchlist
    {
        $sql = "DELETE FROM watchlist WHERE user_id = :user_id AND post_id = :post_id";

        $stmt = db::db()->prepare($sql);
        $stmt->bindParam(':user_id', $this->id);
        $stmt->bindParam(':post_id', $postId);

        $stmt->execute();
    }
}