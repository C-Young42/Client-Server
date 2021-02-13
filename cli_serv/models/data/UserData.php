<?php


class UserData
{
    public static function newUser($data)   // creates a new user in the db
    {
        $sql = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password);";

        $hashedPass = password_hash($data['password'], PASSWORD_DEFAULT);

        $statement = db::db()->prepare($sql);
        $statement->bindParam(':name', $data['name']);
        $statement->bindParam(':email', $data['email']);
        $statement->bindParam(':password', $hashedPass);

        $statement->execute();
    }

    /**
     * @param $idOrEmail
     * @return User
     */
    public static function getUser($idOrEmail)  // fetches a user
    {
        $sql = "SELECT * FROM users WHERE id = :idOrEmail OR email = :idOrEmail";

        $statement = db::db()->prepare($sql);
        $statement->bindParam(':idOrEmail', $idOrEmail);
        $statement->setFetchMode(PDO::FETCH_CLASS, 'User');
        $statement->execute();

        return $statement->fetch();
    }
}