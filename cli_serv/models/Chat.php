<?php


class Chat
{
    public static function getConversation($userTo)   // fetches the chat between two users
    {
        $sql = "SELECT *, IF(user_from = :user_from, true, false) as 'self' FROM messages 
                WHERE (user_to = :user_to AND user_from = :user_from) 
                OR (user_to = :user_from AND user_from = :user_to)
                ORDER BY date";

        $stmt = db::db()->prepare($sql);
        $stmt->bindParam(":user_to", $userTo);
        $stmt->bindParam(":user_from", Account::user()->id);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Message');

        return $stmt->fetchAll();
    }

    public static function getChatUsers()
    {
        $sql = "SELECT u.id, name, MAX(messages.date) as 'date', MAX(messages.body) as 'last_message' FROM messages
                LEFT JOIN users u on messages.user_from = u.id
                WHERE user_to = :user_to
                GROUP BY u.id
                ORDER BY MAX(messages.date) DESC;";

        $stmt = db::db()->prepare($sql);
        $stmt->bindParam(":user_to", Account::user()->id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public static function newMessage($message, $userTo)  // allows a user to write a new message
    {
        $sql = "INSERT INTO messages (user_to, user_from, body) VALUES (:userTo, :userFrom, :body)";

        $stmt = db::db()->prepare($sql);
        $stmt->bindParam(':userTo', $userTo);
        $stmt->bindParam(':userFrom', Account::user()->id);
        $stmt->bindParam(':body', $message);

        if ($stmt->execute()) {
            $stmt = db::db()->prepare("SELECT * FROM messages ORDER BY date DESC LIMIT 1");
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Message');
            $stmt->execute();
            return $stmt->fetch();
        } else {
            return false;
        }
    }
}