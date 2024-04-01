<?php
session_start();
if(isset($_POST["submit"])) {
    echo "complete";
    $userNickname = $_POST["username"];
    $pwd = $_POST["password"];

    require_once "dbh.php";
    include "loginController.php";
    $login = new LoginControl($userNickname, $pwd);

    $login->loginUser();

    header("location: dashboard.php");
}
