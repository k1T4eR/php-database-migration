<?php

class MyAppDatabase {

    private static $connection;

    public static function getConnection() {
        if (!self::$connection) {
            self::$connection = new PDO('mysql:host=127.0.0.1;dbname=test;port=3306', 'root', 'root');
            self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return self::$connection;
    }
}
