<?php

require_once "../requireAll.php";


header('Content-Type: application/json');

if (!Account::isLoggedIn()) {
    $data = new stdClass();
    $data->error = "Unauthorised";
    echo json_encode($data);
} else {

    if (isset($_GET['id'])) {
        // Get specific user id
        $chat = Chat::getConversation($_GET['id']);
        echo json_encode($chat);

    } elseif (isset($_POST['userTo'])) {
        // new message
        $message = htmlentities($_POST['msg']);
        $userTo = $_POST['userTo'];

        $data = new stdClass();

        if ($message = Chat::newMessage($message, $userTo)) {
            $data->message = $message;
        } else {
            $data->message = "Message not successful";
        }

        echo json_encode($data);
    }
    else {
        // Get all chat messages
        $conversations = Chat::getChatUsers();
        echo json_encode($conversations);
    }
}



