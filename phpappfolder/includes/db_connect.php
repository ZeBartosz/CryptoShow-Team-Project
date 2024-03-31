<?php

$host = "localhost";
$dbname = "cryptoshow_db";
$username = "cryptoshowuser";
$password = "cryptoshowpass";

try {
    $dsn = "mysql:host=$host;dbname=$dbname";

    $pdo = new PDO($dsn, $username, $password);

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}