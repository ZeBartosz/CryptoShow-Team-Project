<?php
    require_once "dbh.php";
class Login extends Dbh {

    public function getUser($userNickname, $pwd) {
        $stmt = $this->connect()->prepare('SELECT * FROM registered_user WHERE user_nickname = ? OR user_email = ?;');

        if(!$stmt->execute(array($userNickname, $pwd))) {
            $stmt = null;
            header("location: ../loginPage.php?error=stmtfailed");
            exit();
        }

        if($stmt->rowCount() == 0) {
            $stmt = null;
            header("location: ../loginPage.php?error=usernotfound");
            exit();
        }

        // This will be uncommented when register is going to hash password

        $pwdHashed = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $checkPwd = password_verify($pwd, $pwdHashed[0]['user_hashed_password']);

        if($checkPwd == false) {
            $stmt = null;
            header("location: ../loginPage.php?error=wrongpassword");
            exit();
        } elseif ($checkPwd == true) {
            $stmt = $this->connect()->prepare('SELECT * FROM registered_user WHERE user_nickname = ? OR user_email = ?
            AND user_hashed_password = ?;');


            if(!$stmt->execute(array($userNickname, $userNickname, $pwd))) {
                $stmt = null;
                header("location: ../loginPage.php?error=stmtfailed");
                exit();
            }

            if($stmt->rowCount() == 0) {
                $stmt = null;
                header("location: ../loginPage.php?error=usernotfound");
                exit();
            }
            $user = $stmt->fetchAll(PDO::FETCH_ASSOC);


            session_start();
            $_SESSION["userId"] = $user[0]["user_id"];
            $_SESSION["userNickname"] = $user[0]["user_nickname"];

            $stmt = null;

        }
        $stmt = null;
    }
}