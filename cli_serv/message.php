<?php

require_once "requireAll.php";
// checks if user is logged in or not, if they are not is does not allow them to use the message system

if (Account::isLoggedIn()) {
    require_once("view/message.phtml");
} else {
    echo "please create an account to use this function";
}








