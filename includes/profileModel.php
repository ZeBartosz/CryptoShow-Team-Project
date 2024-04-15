<?php

include_once "dbh.php";

class ProfileModel extends Dbh
{

    protected function getProfileInfo($userId)
    {

        $sql = "SELECT * FROM registered_user WHERE user_id = ?;";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(":userId", $userId, PDO::PARAM_STR);

        if (!$stmt->execute(array($userId))) {
            $stmt = null;
            header("Location: profile.php?error=stmtfailed");
            exit();
        }

        if ($stmt->rowCount() == 0) {
            $stmt = null;
            header("Location: ../php-files/profile.php?error=profilenotFound");
            exit();
        }

        $profileData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $profileData;
    }

    protected function getPublicProfileInfo($username) {
        $sql = "SELECT * FROM registered_user WHERE user_nickname = :username";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(":username", $username, PDO::PARAM_STR);
        if (!$stmt->execute()) {
            $stmt = null;
            header("Location: index.php?error=stmtfailed");
            exit();
        }

        if ($stmt->rowCount() == 0) {
            $stmt = null;
            header("Location: ./index.php?error=profilenotfound");
            exit();
        }

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    protected function setNewProfileInfo($userId, $userNickname, $userName, $userEmail, $pwd, $image, $bio)
    {

        if(empty($pwd)) {
            $stmt = $this->connect()->prepare('UPDATE registered_user SET user_nickname = ?, user_name = ?, user_email = ?, user_image = ?, user_description = ?  WHERE user_id = ?;');
            if (!$stmt->execute(array($userNickname, $userName, $userEmail, $image, $bio, $userId))) {
                $stmt = null;
                header("Location: ../php-files/profile.php?error=stmtfaied");
                exit();
            }
        } else {
            $hashedPwd = password_hash($pwd,PASSWORD_DEFAULT);
            $stmt = $this->connect()->prepare('UPDATE registered_user SET user_nickname = ?, user_name = ?, user_email = ?, user_hashed_password = ?, user_image = ?, user_description = ? WHERE user_id = ?;');
            if (!$stmt->execute(array($userNickname, $userName, $userEmail, $hashedPwd, $image, $bio, $userId))) {
                $stmt = null;
                header("Location: ../php-files/profile.php?error=stmtfaied");
                exit();
            }
        }

    }

    protected function setDeviceCount($userId, $deviceCount)
    {
        $stmt = $this->connect()->prepare('UPDATE registered_user SET user_device_count = ? WHERE user_id = ?;');
        if (!$stmt->execute(array($deviceCount, $userId))) {
            $stmt = null;
            header("Location: ../php-files/profile.php?error=stmtfaied");
            exit();
        }
    }

    protected function CheckUsername($userNickname, $currentNickname) {
        $stmt = $this->connect()->prepare("SELECT user_nickname FROM registered_user WHERE user_nickname = ?;");

        if(!$stmt->execute(array($userNickname))) {
            $stmt = null;
            header("location: registerPage.php?error=stmtfailed");
            exit();
        }

        $nickname = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($currentNickname === $nickname["user_nickname"]) {
            return true;
        } else {
            $resultCheck;
            if ($stmt->rowCount() > 0) {
                $resultCheck = false;
            } else {
                $resultCheck = true;
            }
            return $resultCheck;

        }

    }

    protected function CheckEmail($userEmail, $currentEmail) {
        $stmt = $this->connect()->prepare("SELECT user_email FROM registered_user WHERE user_email = ?;");

        if(!$stmt->execute(array($userEmail))) {
            $stmt = null;
            header("location: registerPage.php?error=stmtfailed");
            exit();
        }

        $email = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($currentEmail === $email) {
            return true;
        } else {
            $resultCheck;
            if ($stmt->rowCount() > 0) {
                $resultCheck = false;
            } else {
                $resultCheck = true;
            }
            return $resultCheck;
        }
    }





    }
