<?php

require __DIR__ . "/../../library/json-response.php";
require __DIR__ . "/../../library/request.php";
require __DIR__ . "/../../models/users.php";

try {

    $token = Request::getHeader("token");
    $user = UserModel::getByToken($token);

    if(!$user){
        Response::json(401, [], ["success" => false, "error" => "Not connected"]);
        die();
    }

    $json = Request::getJsonBody();

    if($user["role"] === "USER" && $user["id"] !== $json["id"]){
        Response::json(401, [], ["success" => false, "error" => "You can't modify this user"]);
        die();
    }
    
    UserModel::updateById($json);
    Response::json(200, [], ["success" => true]);
} catch (PDOException $exception) {
    Response::json(500, [], ["success" => false, "error" => $exception->getMessage()]);
}
