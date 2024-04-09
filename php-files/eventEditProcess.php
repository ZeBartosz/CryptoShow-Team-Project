<?php
session_start();
require_once "validateAdmin.php";
include "db_connect.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);

if(isset($_POST["publish"])) {
    $event_id = $_POST["publish"];

    try {
        $query = "UPDATE event SET is_published=true WHERE event_id=:id";
        $stmt = $pdo->prepare($query);

        $data = [
          ":id" => $event_id,
        ];

        $result = $stmt->execute($data);

        if($result) {
            $_SESSION["message"] = "Published Successfully";
            header("location: ../admin.php");
            exit();
        } else {
            $_SESSION["message"] = "Not Published";
            header("location: ../admin.php");
            exit();
        }

    } catch(PDOException $e) {
        echo $e->getMessage();
    }
}

if(isset($_POST["delete"])) {
    $event_id = $_POST["delete"];

    try {

        $query = "DELETE FROM event WHERE event_id=:id";
        $stmt = $pdo->prepare($query);

        $data = [
            ":id" => $event_id,
        ];
        $result = $stmt->execute($data);

        if($result) {
            $_SESSION["message"] = "Deleted Successfully";
            header("location: ../admin.php");
            exit();
        } else {
            $_SESSION["message"] = "Not Deleted";
            header("location: ../admin.php");
            exit();
        }

    } catch(PDOException $e){
        echo $e->getMessage();
    }

}

if(isset($_POST["submit"])) {

    $id = $_POST["id"];
    $name = $_POST["name"];
    $date = $_POST["date"];
    $venue = $_POST["venue"];
    $description = $_POST["description"];

    try {
        $query = "UPDATE event SET event_name=:name, event_date=:date, event_venue=:venue, event_description=:description WHERE event_id=:id";

        $stmt = $pdo->prepare($query);

        $data = [
            ":name" => $name,
            ":date" => $date,
            ":venue" => $venue,
            ":id" => $id,
            ":description" => $description,
        ];

        $result = $stmt->execute($data);

        if($result) {
            $_SESSION["message"] = "Saved Successfully";
            header("location: ../admin.php");
            exit();
        } else {
            $_SESSION["message"] = "Not Saved";
            header("location: ../admin.php");
            exit();
        }

    } catch (PDOException $e) {
        echo $e->getMessage();
    }


}