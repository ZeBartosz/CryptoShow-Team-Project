<?php
include_once "dbh.php";
class RegisterModel extends Dbh {

    protected function setUser($userNickname, $userName, $pwd, $email) {
        $stmt = $this->connect()->prepare("INSERT INTO registered_user (user_nickname, user_name, user_hashed_password,
        user_email, user_registered_timestamp) VALUES (?, ?, ?, ?, NOW());");



        $hashedPwd = password_hash($pwd,PASSWORD_DEFAULT);

        if(!$stmt->execute(array($userNickname, $userName, $hashedPwd, $email))) {
            $stmt = null;
            header("location: register.php?error=stmtfailed");
            exit();
        }
        $stmt = null;
    }

    protected function checkUser($userNickname, $email) {
        $stmt = $this->connect()->prepare("SELECT user_nickname FROM registered_user WHERE user_nickname =? 
        OR user_email = ?;");

        if(!$stmt->execute(array($userNickname, $email))) {
            $stmt = null;
            header("location: register.php?error=stmtfailed");
            exit();
        }

        $resultCheck;
        if ($stmt->rowCount() > 0) {
            $resultCheck = false;
        } else {
            $resultCheck = true;
        }
        return $resultCheck;

    }
}
