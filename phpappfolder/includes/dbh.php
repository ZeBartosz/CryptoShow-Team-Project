<?php

class Dbh {

    protected function connect(){
        try {
            $host = "localhost";
            $dbname = "cryptoshow_db";
            $username = "cryptoshowuser";
            $password = "cryptoshowpass";

            $dsn = "mysql:host=$host;dbname=$dbname";

            $pdo = new PDO($dsn, $username, $password);
            return $pdo;
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }
}