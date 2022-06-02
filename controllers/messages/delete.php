<?php

require __DIR__ . "/../../library/json-response.php";
require __DIR__ . "/../../models/users.php";
require __DIR__ . "/../../library/request.php";
require __DIR__ . "/../../models/messages.php";


try {

    $token = Request::getHeader("token");
    $user = UserModel::getByToken($token);

    if(!$user){
        Response::json(401, [], ["success" => false, "error" => "Not connected"]);
        die();
    }

    if($user["role"] === "USER"){
        Response::json(401, [], ["success" => false, "error" => "You can't delete any message"]);
        die();
    }

    $json = Request::getJsonBody();
    $message = MessageModel::getById($json["id"]);

    if (!$message) {
        Response::json(404, [], ["success" => false, "error" => "Message not found"]);
        die();
    }

    MessageModel::deleteById($json);
    Response::json(200, [], ["success" => true]);
} catch (PDOException $exception) {
    Response::json(500, [], ["success" => false, "error" => $exception->getMessage()]);
}
