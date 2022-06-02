<?php

require __DIR__ . "/../../library/json-response.php";
require __DIR__ . "/../../library/request.php";
require __DIR__ . "/../../models/users.php";
require __DIR__ . "/../../models/rooms.php";

try {
    $token = Request::getHeader("token");
    $user = UserModel::getByToken($token);

   
    if(!$user){
        Response::json(401, [], ["success" => false, "error" => "Not connected"]);
        die();
    }
    $rooms = RoomModel::getall();
    Response::json(200, [], ["rooms" => $rooms]);
        die();
   

}catch(PDOException $exception) {
    $errorMessage = $exception->getMessage();
    Response::json(500, [], ["error" =>"Error while Accessing the database: $errorMessage"]);
}