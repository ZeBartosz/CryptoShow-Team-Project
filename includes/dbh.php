<?php

/**
 * Dbh (Database Handler) class responsible for creating and managing database connections.
 */
class Dbh {

    /**
     * Establishes a PDO connection to a MySQL database.
     * 
     * This method attempts to create a new PDO instance using specified database credentials.
     * It constructs the Data Source Name (DSN) with parameters for the host and database name,
     * then tries to connect using the username and password. If the connection is successful,
     * it returns the PDO object. If the connection fails, it terminates the script and outputs
     * an error message.
     *
     * @return PDO A PDO object on success, or terminates the script on failure.
     */
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
