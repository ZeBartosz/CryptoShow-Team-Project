<?php

include_once "dbh.php";

class ProfileInfo extends Dbh
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


    protected function setNewProfileInfo($userId, $userNickname, $userName, $userEmail)
    {

        $stmt = $this->connect()->prepare('UPDATE registered_user SET user_nickname = ?, user_name = ?, user_email = ? WHERE user_id = ?;');

        if (!$stmt->execute(array($userNickname, $userName, $userEmail, $userId))) {
            $stmt = null;
            header("Location: ../php-files/profile.php?error=stmtfaied");
            exit();
        }

        $stmt = null;

    }


}