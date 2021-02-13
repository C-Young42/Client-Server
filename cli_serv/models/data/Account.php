<?php


class Account
{
    public static function attemptLogin($email, $password) // error checkers for login
    {

        $user = UserData::getUser($email);

        if (!$user) {
            return false;
        }

        if (!password_verify($password, $user->password)) {
            return false;
        }

        // Set the session variables
        $_SESSION['userId'] = json_encode($user->id);
        return true;
    }

    /**
     * @return User
     */
    public static function user()
    {
        return UserData::getUser(json_decode($_SESSION['userId']));
    }

    public static function logout()
    {
        unset($_SESSION['userId']);
    }

    public static function isLoggedIn()
    {
        return isset($_SESSION['userId']);
    }
}