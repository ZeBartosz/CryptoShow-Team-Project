<?php
session_start();

require_once("db_connect.php");

if (isset($_POST["username"]) && isset($_POST["password"])) {

    $username = htmlspecialchars($_POST["username"]);
    $password = htmlspecialchars($_POST["password"]);

    $sql = "SELECT * FROM registered_user WHERE user_nickname = :username";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":username", $username, PDO::PARAM_STR);

    if($stmt->execute()) {
        if($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if($password === $user["user_hashed_password"]) {
                $_SESSION["username"] = $user["username"];
                $_SESSION["user_id"] = $user["user_id"];
                header("Location: dashboard.php");
                exit();
            } else {
                echo "Invalid password";
            }
        }
    } else {
        echo "Erorr executing statement";
    }
} else {
    echo "Please provide username and password";
}