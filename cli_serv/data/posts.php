<?php

require_once "../requireAll.php";


header('Content-Type: application/json');

$offset = isset($_GET['offset']) ? $_GET['offset'] : 0;
$posts = PostData::fetchPostsOffset($offset);

echo json_encode($posts);

