<?php

if(isset($_POST["submit"])) {
    $userNickname = $_POST["username"];
    $firstName = $_POST["name"];
    $lastName = $_POST["lastname"];
    $userName = $firstName . " " . $lastName;
    $pwd = $_POST["password"];
    $repeatPwd = $_POST["rptPassword"];
    $email = $_POST["email"];

    require_once "dbh.php";
    include "registerController.php";
    $register = new registerControl($userNickname, $userName, $pwd, $repeatPwd, $email);

    $register->registerUser();

    header("location: ../login.php?registersuccess");
}
