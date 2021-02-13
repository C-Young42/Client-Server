<?php


class PostData
{
    public static function search($searchTerm)  // allows a user to search for a post
    {
        $searchTerm = htmlentities($searchTerm);

        $sql = "SELECT * FROM posts WHERE title like '%$searchTerm%'";

        $stmt = db::db()->prepare($sql);#

        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Post');

        return $stmt->fetchAll();
    }

    public static function fetchAllPosts()  // gets all posts
    {
        $sql = 'SELECT * FROM posts ORDER BY created_at';

        $statement = db::db()->prepare($sql);
        $statement->setFetchMode(PDO::FETCH_CLASS, 'Post');
        $statement->execute();

        return $statement->fetchAll();
    }

    public static function postById($id)  // fetches a post by its id
    {
        $sql = 'SELECT * FROM posts WHERE id = :id';

        $statement = db::db()->prepare($sql);
        $statement->bindParam(':id', $id);
        $statement->setFetchMode(PDO::FETCH_CLASS, 'Post');
        $statement->execute();

        return $statement->fetch();
    }

    public static function fetchPostsOffset($offset)
    {
        $sql = "SELECT * FROM posts ORDER BY created_at DESC LIMIT 5 OFFSET $offset";

        $stmt = db::db()->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Post');
        $stmt->execute();

        $posts = $stmt->fetchAll();
        return $posts;
    }

    public static function newPost($postData)  // creates a new post
    {
        $sql = 'INSERT INTO posts (user_id, title, content) VALUES (:user_id, :title, :content)';

        $statement = db::db()->prepare($sql);
        $statement->bindParam(':user_id', Account::user()->id);
        $statement->bindParam(':title', $postData['title']);
        $statement->bindParam(':content', $postData['content']);

        $statement->execute();
    }

    public static function newComment($commentBody, $postId)  // creates a new comment on a post
    {
        $commentBody = htmlentities($commentBody);

        $sql = "INSERT INTO comments (user_id, post_id, body) VALUES (:userId, :postId, :body)";

        $stmt = db::db()->prepare($sql);
        $stmt->bindParam(':userId', Account::user()->id);
        $stmt->bindParam(':postId', $postId);
        $stmt->bindParam(':body', $commentBody);
        $stmt->execute();
    }
}