<?php

session_start();

if(isset($_POST["submit"])) {

    $id = $_SESSION["user_id"];

    $name = htmlspecialchars($_POST["name"], ENT_QUOTES, "UTF-8");
    $image = htmlspecialchars($_POST["image"], ENT_QUOTES, "UTF-8");
    $visible = htmlspecialchars($_POST["visible"], ENT_QUOTES, "UTF-8" );


    include_once "dbh.php";
    include_once "deviceProcess.php";
    include_once "deviceController.php";
    include_once "deviceView.php";
    $deviceInfo = new DeviceController($id);

    $deviceInfo->insertDevice($name, $image, $visible);

    header("location: profile.php?error=none");
}
