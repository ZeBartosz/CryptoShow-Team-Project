<?php

session_start();

if(isset($_POST["submit"])) {

    $id = $_SESSION["user_id"];

    $nickname = htmlspecialchars($_POST["nickname"], ENT_QUOTES, "UTF-8");
    $name = htmlspecialchars($_POST["name"], ENT_QUOTES, "UTF-8");
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL, );


    include_once "dbh.php";
    include_once "profileinfo.php";
    include_once "profileinfo_contrl.php";
    include_once "profileinfo_view.php";
    $profileInfo = new ProfileInfoContrl($id);

    $profileInfo->updateProfileInfo($nickname, $name, $email);

    header("location: profile.php?error=none");
}
