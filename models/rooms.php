<?php

class RoomModel{
    public static function getAll(){
        $connection = getDatabaseConnection();

        $getRoomQuery = $connection->query("SELECT * FROM rooms");

        $rooms = $getRoomQuery->fetchAll();

        return $rooms;
    }

    public static function create($room)
    {
        $connection = getDatabaseConnection();
        $createRoomQuery = $connection->prepare("INSERT INTO rooms(name, description) VALUES(:name, :description);");
        $createRoomQuery->execute($room);
    }

    public static function getById($id)
    {
        $connection = getDatabaseConnection();
        $getRoomByIdQuery = $connection->prepare("SELECT * FROM rooms WHERE id = :id;");

        $getRoomByIdQuery->execute(
            [
            "id" => $id
            ]
        );

        $room = $getRoomByIdQuery->fetch();

        return $room;
    }

    public static function deleteById($room)
    {
        $connection = getDatabaseConnection();
        $deleteByIdQuery = $connection->prepare("DELETE FROM rooms WHERE id = :id;");
        $deleteByIdQuery->execute($room);
    }

    public static function updateById($json)
    {
        $allowedColumns = ["id","name","description"];
        $columns = array_keys($json);
        $set = [];

        foreach ($columns as $column) {
            if (!in_array($column, $allowedColumns)) {
                continue;
            }

            $set[] = "$column = :$column";
        }

        $set = implode(", ", $set);
        $sql = "UPDATE rooms SET $set WHERE id = :id";
        $connection = getDatabaseConnection();
        $query = $connection->prepare($sql);
        $query->execute($json);
    }


}