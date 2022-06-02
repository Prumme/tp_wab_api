<?php

require __DIR__ . "/../../library/json-response.php";
require __DIR__ . "/../../library/request.php";
require __DIR__ . "/../../models/users.php";
require __DIR__ . "/../../models/messages.php";

try {
    $token = Request::getHeader("token");
    $user = UserModel::getByToken($token);

   
    if(!$user){
        Response::json(401, [], ["success" => false, "error" => "Not connected"]);
        die();
    }

    if ($user["role"] === "ADMINISTRATOR"){
        $messages=MessageModel::getAll();
        Response::json(200, [], ["messages" => $messages]);
        die();
    }
    Response::json(401, [], ["success" => false, "error" => "Not Admin"]);
    die();

}catch(PDOException $exception) {
    $errorMessage = $exception->getMessage();
    Response::json(500, [], ["error" =>"Error while Accessing the database: $errorMessage"]);
}