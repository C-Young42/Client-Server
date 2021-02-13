<?php
require_once "requireAll.php";


if (isset($_POST['search'])) {
    // Get searched posts
    $posts = PostData::search($_POST['search']);
}

require_once("view/search.phtml");




