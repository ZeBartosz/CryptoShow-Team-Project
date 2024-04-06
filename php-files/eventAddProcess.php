<?php
session_start();
require_once "validateAdmin.php";
include "db_connect.php";

if(isset($_POST["submit"])) {

    $name = $_POST["name"];
    echo $_POST["name"];
    $date = $_POST["date"];
    $desc = $_POST["desc"];
    echo $_POST["date"];
    $venue = $_POST["venue"];
    echo $_POST["venue"];
    $is_published = isset($_POST["publish"])? 1 : 0;

    try {
        $query = "INSERT INTO event (event_name, event_date, event_description, event_venue, is_published) VALUES (:name, :date, :desc, :venue, :publish)";

        $stmt = $pdo->prepare($query);

        $data = [
            ":name" => $name,
            ":date" => $date,
            ":desc" => $desc,
            ":venue" => $venue,
            ":publish" => $is_published,
        ];

        $result = $stmt->execute($data);

        if($result) {
            $_SESSION["message"] = "Added Successfully";
            header("location: ../admin.php");
            exit();
        } else {
            $_SESSION["message"] = "Not Added";
            header("location: ../admin.php");
            exit();
        }

    } catch (PDOException $e) {
        echo $e->getMessage();
    }


}