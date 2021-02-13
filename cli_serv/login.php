<?php

require_once "requireAll.php";


if (isset($_POST['login'])) {

    $credentials =
    list (
        'email' => $_POST['email'],
        'password' => $_POST['password'],
    ) = $_POST;

    // Html entities for each request param
    $credentials = Util::cleanRequestParams($credentials);

    // Attempt login
    if (Account::attemptLogin($credentials['email'], $credentials['password'])) {
        // Login successful - redirect etc
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    } else {

        // Login failed error message
        $loginError = 'These credentials do not match our records';
    }
}
