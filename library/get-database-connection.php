<?php

function getDatabaseConnection() {
    $driver = "mysql";

    $databaseName = "tp-web-api";

    $hostName = "localhost";

    $dataSourceName = "$driver:dbname=$databaseName;host=$hostName";

    $userName = "aurel";

    $password = "aurel";

    $options = [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ];

    /**
     * Récupérer une connection à une base de données
     * @see https://www.php.net/manual/en/pdo.construct.php
     */
    $connection = new PDO($dataSourceName, $userName, $password, $options);

    return $connection;
}
