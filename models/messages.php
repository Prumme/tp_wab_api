<?php



class MessageModel{
    public static function getAll(){
        $connection = getDatabaseConnection();

        $getMessageQuery = $connection->query("SELECT * FROM messages");

        $message = $getMessageQuery->fetchAll();

        return $message;
    }

    public static function create($message)
    {
        $connection = getDatabaseConnection();
        $createMessageQuery = $connection->prepare("INSERT INTO messages(body,timestamp, userId, roomId) VALUES(:body, :timestamp, :userId, :roomId);");
        $createMessageQuery->execute($message);
    }

    public static function getById($id)
    {
        $connection = getDatabaseConnection();
        $getMessageByIdQuery = $connection->prepare("SELECT * FROM messages WHERE id = :id;");

        $getMessageByIdQuery->execute(
            [
            "id" => $id
            ]
        );

        $message = $getMessageByIdQuery->fetch();

        return $message;
    }

    public static function getByRoom($roomId)
    {
        $connection = getDatabaseConnection();
        $getRoomByIdQuery = $connection->prepare("SELECT * FROM messages WHERE roomId = :roomId;");
        $getRoomByIdQuery->execute(["roomId" => $roomId]);
        
        return $getRoomByIdQuery->fetch();
    }

    public static function deleteById($message)
    {
        $connection = getDatabaseConnection();
        $deleteByIdQuery = $connection->prepare("DELETE FROM messages WHERE id = :id;");
        $deleteByIdQuery->execute($message);
    }

    public static function updateById($json)
    {
        $allowedColumns = ["id","body","timestamp", "userId", "roomId"];
        $columns = array_keys($json);
        $set = [];

        foreach ($columns as $column) {
            if (!in_array($column, $allowedColumns)) {
                continue;
            }

            $set[] = "$column = :$column";
        }

        $set = implode(", ", $set);
        $sql = "UPDATE messages SET $set WHERE id = :id";
        $connection = getDatabaseConnection();
        $query = $connection->prepare($sql);
        $query->execute($json);
    }



}