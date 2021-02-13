<?php

require_once "requireAll.php";
// checks if submit button has been pressed
if (isset($_POST['submit']) && !Account::isLoggedIn()) {
    // Post varibales, get form
    // html entities each value
    foreach ($_POST as $key => $value) {
        $_POST[$key] = htmlentities($value);
    }

    // Destruct array
    $data = list(
        'name' => $name,
        'email' => $email,
        'password' => $password,
        'password-confirm' => $confirmPassword
        ) = $_POST;

    $error = '';
// errros checkers
    if ($confirmPassword !== $password) {
        $error = 'Passwords do not match';
    } else if (UserData::getUser($email)) {
        $error = 'User already exists';
    } else if (!$name || !$email || !$password || !$confirmPassword) {
        $error = 'Please enter all fields';
    }

    if (!$error) {

        UserData::newUser($data);
    }
} else if (Account::isLoggedIn()) {
    header('Location: /');
}

require_once ("view/signup.phtml");