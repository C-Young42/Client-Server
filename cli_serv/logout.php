<?php

require_once "requireAll.php";


// logs the user out

if (isset($_POST['logout']) && Account::isLoggedIn()) {
    Account::logout();
    header('Location: /');
} else {
    header('Location: ' . $_REQUEST['']);
}