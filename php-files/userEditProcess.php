<?php
session_start();
require_once "validateAdmin.php";
include "db_connect.php";


if(isset($_POST["delete"])) {
    $user_id = $_POST["delete"];

    try {

        $query = "DELETE FROM registered_user WHERE user_id=:userid";
        $stmt = $pdo->prepare($query);
        
        $data = [
            ":userid" => $user_id,
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

    $user_id = $_POST["userid"];
    $username = $_POST["username"];
    $fullname = $_POST["fullname"];
    $email = $_POST["email"];
    $is_admin = isset($_POST["admin"]) ? true : false;

    try {
        $query = "UPDATE registered_user SET user_nickname=:nickname, user_name=:fullname, user_email=:email, is_admin=:is_admin WHERE user_id=:userid";
        $stmt = $pdo->prepare($query);

        $data = [
            ":nickname" => $username,
            ":fullname" => $fullname,
            ":email" => $email,
            ":userid" => $user_id,
            ":is_admin" => $is_admin
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