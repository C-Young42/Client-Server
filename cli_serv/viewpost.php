<?php
require_once "requireAll.php";

if (!isset($_GET['id'])) {
    header('Location: posts.php');
}

// checks if user is logged in
if (Account::isLoggedIn()) {

    $user = Account::user();
// shows the users watchlist
    if (isset($_POST['watch'])) {
        $user->watchPost($_GET['id']);
    } else if (isset($_POST['unwatch'])) {
        $user->unwatchPost($_GET['id']);
    }
}

    if (isset($_POST['newComment'])){
        PostData::newComment($_POST['content'], $_GET['id']);
    }

// finds post by using the postID
$findPost = PostData::postById(htmlentities($_GET['id']));

require_once("view/viewpost.phtml");