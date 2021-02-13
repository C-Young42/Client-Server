<?php
session_start();
set_include_path($_SERVER['DOCUMENT_ROOT']);
require_once "models/lib/Env.php";
require_once Env::dir() . '/models/User.php';
require_once Env::dir() . '/models/Post.php';
require_once Env::dir() . '/models/Message.php';
require_once Env::dir() . '/models/Chat.php';
require_once Env::dir() . '/models/Watchlist.php';
require_once Env::dir() . '/models/Comment.php';
require_once Env::dir() . "/models/lib/db.php";
require_once Env::dir() . "/models/lib/Util.php";
require_once Env::dir() . '/models/data/UserData.php';
require_once Env::dir() . '/models/data/PostData.php';
require_once Env::dir() . '/models/data/Account.php';

// used so only need one require once for all these files