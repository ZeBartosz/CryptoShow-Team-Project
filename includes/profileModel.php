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


    protected function setNewProfileInfo($userId, $userNickname, $userName, $userEmail, $pwd)
    {

        if(empty($pwd)) {
            $stmt = $this->connect()->prepare('UPDATE registered_user SET user_nickname = ?, user_name = ?, user_email = ? WHERE user_id = ?;');
            if (!$stmt->execute(array($userNickname, $userName, $userEmail, $userId))) {
                $stmt = null;
                header("Location: ../php-files/profile.php?error=stmtfaied");
                exit();
            }
        } else {
            $hashedPwd = password_hash($pwd,PASSWORD_DEFAULT);
            $stmt = $this->connect()->prepare('UPDATE registered_user SET user_nickname = ?, user_name = ?, user_email = ?, user_hashed_password = ? WHERE user_id = ?;');
            if (!$stmt->execute(array($userNickname, $userName, $userEmail, $hashedPwd, $userId))) {
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



    }
