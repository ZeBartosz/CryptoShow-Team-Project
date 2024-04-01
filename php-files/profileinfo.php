<?php

    include ("dbh.php");
    echo "found id" . $_SESSION['user_id'];

class ProfileInfo extends Dbh
{

    protected function getProfileInfo($userId) {

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
            header("Location: profile.php?error=profilenotFound");
            exit();
        }

        $profileData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $profileData;
    }



    protected function setNewProfileInfo($userId, $userNickname, $userName, $userEmail) {

        $stmt = $this->prepare('UPDATE registered_user SET user_nickname = ?, user_name = ?, user_email = ? WHERE user_id = ?;');

        if (!$stmt->execute(array($userId, $userNickname,$userName ,$userEmail))) {
            $stmt = null;
            header("Location: profile.php?error=stmtfailed");
            exit();
        }

       $stmt = null;
    }


}