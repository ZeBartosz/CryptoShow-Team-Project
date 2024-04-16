<?php

include_once "dbh.php";

/**
 * Class ProfileModel
 * This class handles operations related to profile information in the database
 * @extends Dbh connection to the database
 */
class ProfileModel extends Dbh {

    /**
     * Retrieves profile information for a given userId
     *
     * @param int $userId The ID of the user
     * @return array The profile information as an array
     */
    protected function getProfileInfo($userId){

        //query for the database
        $sql = "SELECT * FROM registered_user WHERE user_id = ?;";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(":userId", $userId, PDO::PARAM_STR);

        //checks for any errors with the query
        if (!$stmt->execute(array($userId))) {
            $stmt = null;
            header("Location: profile.php?error=stmtfailed");
            exit();
        }

        //checks if the query returns nothing
        if ($stmt->rowCount() == 0) {
            $stmt = null;
            header("Location: profile.php?error=profilenotFound");
            exit();
        }

        //fetches an array containing all the information for the user
        $profileData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $profileData;
    }

    /**
     * Retrieves profile information for a given username
     *
     * @param string $username The nickname of the user
     * @return array The profile information as an array
     */
    protected function getPublicProfileInfo($username) {

        //query for the database
        $sql = "SELECT * FROM registered_user WHERE user_nickname = :username";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(":username", $username, PDO::PARAM_STR);

        //checks for any errors with the query
        if (!$stmt->execute()) {
            $stmt = null;
            header("Location: index.php?error=stmtfailed");
            exit();
        }

        //checks if the query returns nothing
        if ($stmt->rowCount() == 0) {
            $stmt = null;
            header("Location: index.php?error=profilenotfound");
            exit();
        }

        //fetches an array containing all the information for the user
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Updates information for a user
     *
     * @param int $userId The ID of the user
     * @param string $userNickname The new nickname of the user
     * @param string $userName The new name of the user
     * @param string $userEmail The new email of the user
     * @param string $pwd The new password of the user
     * @param string $image The new image URL of the user
     * @param string $bio The new biography of the user
     */
    protected function setNewProfileInfo($userId, $userNickname, $userName, $userEmail, $pwd, $image, $bio) {
        //check if the password is empty
        if(empty($pwd)) {
            //query without the $pwd
            $stmt = $this->connect()->prepare('UPDATE registered_user SET user_nickname = ?, user_name = ?, user_email = ?, user_image = ?, user_description = ?  WHERE user_id = ?;');
            //checks for any errors with the query
            if (!$stmt->execute(array($userNickname, $userName, $userEmail, $image, $bio, $userId))) {
                $stmt = null;
                header("Location: profile.php?error=stmtfaied");
                exit();
            }
            //if the password is not empty
        } else {
            //hash the password
            $hashedPwd = password_hash($pwd,PASSWORD_DEFAULT);
            //query
            $stmt = $this->connect()->prepare('UPDATE registered_user SET user_nickname = ?, user_name = ?, user_email = ?, user_hashed_password = ?, user_image = ?, user_description = ? WHERE user_id = ?;');
            //checks for any errors with the query
            if (!$stmt->execute(array($userNickname, $userName, $userEmail, $hashedPwd, $image, $bio, $userId))) {
                $stmt = null;
                header("Location: profile.php?error=stmtfaied");
                exit();
            }
        }

    }

    /**
     * Updates device count for a user when adding or deleting device
     *
     * @param int $userId The ID of the user
     * @param int $deviceCount The new device count for the user
     */
    protected function setDeviceCount($userId, $deviceCount) {
        //query
        $stmt = $this->connect()->prepare('UPDATE registered_user SET user_device_count = ? WHERE user_id = ?;');
        //checks for any errors with the query
        if (!$stmt->execute(array($deviceCount, $userId))) {
            $stmt = null;
            header("Location: profile.php?error=stmtfaied");
            exit();
        }

    }

    /**
     * Check if a given nickname is available
     *
     * @param string $userNickname The nickname to check.
     * @param string $currentNickname The current nickname of the user.
     * @return bool True if the nickname is available or if currentNickname and userNickname are the same, false otherwise.
     */
    protected function CheckUsername($userNickname, $currentNickname) {
        //query
        $stmt = $this->connect()->prepare("SELECT user_nickname FROM registered_user WHERE user_nickname = ?;");

        //checks for any errors with the query
        if(!$stmt->execute(array($userNickname))) {
            $stmt = null;
            header("location: profile.php?error=stmtfailed");
            exit();
        }

        //fetches the row that contains the userNickname
        $nickname = $stmt->fetch(PDO::FETCH_ASSOC);

        //checks if currentNickname and userNickname are the same
        if ($currentNickname === $nickname["user_nickname"]) {
            return true;
        } else {
            //if not true then check if the query gives a row back
            $resultCheck;
            if ($stmt->rowCount() > 0) {
                $resultCheck = false;
            } else {
                $resultCheck = true;
            }
            return $resultCheck;

        }

    }

    /**
     * Check if a given email is available.
     *
     * @param string $userEmail The email to check.
     * @param string $currentEmail The current email of the user.
     * @return bool True if the email is available or if userEmail and CurrentEmail are the same , false otherwise.
     */
    protected function CheckEmail($userEmail, $currentEmail) {
        //query
        $stmt = $this->connect()->prepare("SELECT user_email FROM registered_user WHERE user_email = ?;");

        //checks for any errors with the query
        if(!$stmt->execute(array($userEmail))) {
            $stmt = null;
            header("location: profile.php?error=stmtfailed");
            exit();
        }

        //fetches the row that contains the userNickname
        $email = $stmt->fetch(PDO::FETCH_ASSOC);

        //checks if currentNickname and userNickname are the same
        if ($currentEmail === $email["user_email"]) {
            return true;
        } else {
            //if not true then check if the query gives a row back
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