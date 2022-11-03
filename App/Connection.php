<?php

    namespace App;

    use Exception;

    class Connection {
        public static function getDb() {
            try {
                $conn = new \PDO("mysql:host=localhost;dbname=groweb;charset=utf8", "root", "");
                return $conn;
            } catch(\PDOException $e) {

            }
        }
    }

?>