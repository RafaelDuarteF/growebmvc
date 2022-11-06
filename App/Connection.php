<?php

    namespace App;

    class Connection {
        public static function getDb() {
            try {
                $conn = new \PDO("mysql:host=127.0.0.1:3306;dbname=groweb;charset=utf8", "root", "");
                return $conn;
            } catch(\PDOException $e) {
                return false;
            }
        }
    }

?>