<?php

require __DIR__ . "/../../library/json-response.php";
require __DIR__ . "/../../library/request.php";
require __DIR__ . "/../../models/users.php";


$json = Request::getJsonBody();

$user = UserModel::getByEmail($json["email"]);

if (!$user){
    Response::json(400, [], ["success" => false, "error" => " Bad Request"]);
    die();
}

if ($json["password"] !== $user["password"]){
    Request::json(400, [] , ["success" => false, "error" => "Bad Request"]);
    die();
}

$token = bin2hex(random_bytes(16));

$user["token"] = $token;

UserModel::updateById($user);

Response::json(200, [], ["success" => true, "token" => $token]);