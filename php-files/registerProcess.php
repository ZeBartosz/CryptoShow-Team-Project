<?php

if(isset($_POST["submit"])) {
    $userNickname = $_POST["username"];
    $pwd = $_POST["password"];
    $repeatPwd = $_POST["rptPassword"];
    $email = $_POST["email"];

    require_once "dbh.php";
    include "registerController.php";
    $register = new registerControl($userNickname, $pwd, $repeatPwd, $email);

    $register->registerUser();

    header("location: ../loginPage.php");
}