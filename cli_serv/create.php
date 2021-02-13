<?php

require_once "requireAll.php";

// creates a post

if (!Account::isLoggedIn()) {
    header('Location: /');
}

if(isset($_POST['post'])) {

    foreach ($_POST as $key => $value) {
        $_POST[$key] = htmlentities($value);
    }

    $data = list(
        'title' => $title,
        'content' => $content,
        ) = $_POST;

    $error = '';
    if (!$title || !$content) {
        $error = 'Please enter all required fields';
    }

    if (!$error) {
        PostData::newPost($data);
    }
}

require_once("view/create.phtml");




