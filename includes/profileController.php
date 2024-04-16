<?php

include_once "deviceModel.php";

/**
 * Class ProfileController
 * Handles control logic for profile-related operations
 * @extends ProfileModel allows the use of crud function
 */
class ProfileController extends ProfileModel {

    private $userId;
    private $model;

    /**
     * Constructor
     * Initialises a new instance of the ProfileController class
     * @param int $userId The ID of the user
     */
    public function __construct($userId) {
        $this->userId = $userId;
    }


    /**
     * Validates the parameters and updates a specific profile
     *
     * @param string $userNickname The new nickname of the user
     * @param string $userName The new name of the user
     * @param string $userEmail The new email of the user
     * @param string $pwd The new password of the user
     * @param string $repeatPwd The repeated password for confirmation
     * @param string $image The new location of the device image
     * @param string $bio The new bio of the user
     * @param string $currentNickname The current nickname of the user
     * @param string $currentEmail The current email of the user
     */
    public function updateProfileInfo($userNickname, $userName, $userEmail, $pwd, $repeatPwd, $image, $bio, $currentNickname, $currentEmail) {

        //checks if any of the inputs are empty
        if ($this->emptyInputCheck($userNickname, $userName, $userEmail)) {
            $_SESSION["message"] = "Error: Empty input ";
            header("location: {$_SERVER['PHP_SELF']}");
            exit();
        }

        //checks if $userNickname is a valid string
        if (!$this->invalidUsername($userNickname)) {
            $_SESSION["message"] = "Error: Invalid nickname";
            header("location: {$_SERVER['PHP_SELF']}");
            exit();
        }

        //checks if $bio is at it limit(255 chars)
        if (!$this->reachedDescriptionLimit($bio)) {
            $_SESSION["message"] = "Error: Description limit";
            header("location: {$_SERVER['PHP_SELF']}");
            exit();
        }

        //checks if $userName is a valid string
        if (!$this->invalidName($userName)) {
            $_SESSION["message"] = "Error: Invalid name";
            header("location: {$_SERVER['PHP_SELF']}");
            exit();
        }

        //checks if $userEmail is a valid string
        if (!$this->invalidEmail($userEmail)) {
            $_SESSION["message"] = "Error: Invalid email";
            header("location: {$_SERVER['PHP_SELF']}");
            exit();
        }

        //checks if $pwd and $repeatPwd are matching
        if (!$this->pwdMatch($pwd, $repeatPwd)) {
            $_SESSION["message"] = "Error: Password not matching";
            header("location: {$_SERVER['PHP_SELF']}");
            exit();
        }

        //checks if $userNickname is already taken
        if ($this->userNicknameTaken($userNickname, $currentNickname)) {
            $_SESSION["message"] = "Error: User nickname already taken ";
            header("location: {$_SERVER['PHP_SELF']}");
            exit();
        }

        //checks if $userNickname is already taken
        if ($this->userEmailTaken($userEmail, $currentEmail)){
            $_SESSION["message"] = "Error: Email already taken ";
            header("location: {$_SERVER['PHP_SELF']}");
            exit();
        }


        //executes the function with the parameters
        $this->setNewProfileInfo($this->userId, $userNickname, $userName, $userEmail, $pwd, $image, $bio);
    }

    /**
     * Update device count for a user
     *
     * @param int $deviceCount The new device count for the user
     */
    public function updateDeviceCount($deviceCount){
        $this->setDeviceCount($this->userId, $deviceCount);
    }

    /**
     * Check if inputs are empty
     *
     * @param string $userNickname The nickname of the user
     * @param string $userName The name of the user
     * @param string $userEmail The email of the user
     * @return bool True if any of the input fields are empty, false otherwise
     */

    private function emptyInputCheck($userNickname, $userName, $userEmail)
    {
        $result = null;
        if (empty($userNickname) || empty($userName) || empty($userEmail)) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    /**
     * Check if the username is valid
     *
     * @param string $userNickname The nickname to check
     * @return bool True if the nickname is valid, false otherwise
     */
    private function invalidUsername($userNickname) {
        $result;
        //checks if $userNickname contains any special characters
        if(!preg_match("/^[a-zA-Z-0-9]*$/", $userNickname)) {
            $result = false;
        } else {
            $result = true;
        }
        return $result;
    }

    /**
     * Check if the name is valid
     *
     * @param string $userName The name to check
     * @return bool True if the name is valid, false otherwise
     */
    private function invalidName($userName) {
        $result;
        //checks if $userName contains any special characters
        if(!preg_match("/^[a-zA-Z]+(\s[a-zA-Z]+)$/", $userName)) {
            $result = false;
        } else {
            $result = true;
        }
        return $result;
    }

    /**
     * Check if the email is valid
     *
     * @param string $userEmail The email to check
     * @return bool True if the email is valid, false otherwise
     */
    private function invalidEmail($userEmail) {
        $result;
        //filters the $userEmail
        if (!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
            $result = false;
        } else {
            $result = true;
        }
        return $result;
    }

    /**
     * Check if passwords match
     *
     * @param string $pwd The password
     * @param string $repeatPwd The repeated password
     * @return bool True if passwords match, false otherwise
     */
    private function pwdMatch($pwd, $repeatPwd) {
        $result;
        if($pwd !== $repeatPwd) {
            $result = false;
        } else {
            $result = true;
        }
        return $result;
    }

    /**
     * Check if the description limit is reached
     *
     * @param string $event_description The description to check
     * @return bool True if the description limit is not reached, false otherwise
     */
    private function reachedDescriptionLimit($event_description) {
        $result;
        if(strlen($event_description) > 255) {
            $result = false;
        } else {
            $result = true;
        }
        return $result;
    }

    /**
     * Check if the user nickname is already taken
     *
     * @param string $userNickname The nickname to check
     * @param string $currentNickname The current nickname of the user
     * @return bool False if the user nickname is available, True otherwise
     */
    private function userNicknameTaken ($userNickname, $currentNickname) {
        $result;
        if($this->CheckUsername($userNickname, $currentNickname)){
            $result = false;
        } else {
            $result = true;
        }
        return $result;

    }

    /**
     * Check if the user email is already taken
     *
     * @param string $userEmail The email to check
     * @param string $currentEmail The current email of the user
     * @return bool False if the user email is available, True otherwise
     */
    private function userEmailTaken ($userEmail, $currentEmail){
        $result;
        if($this->CheckEmail($userEmail, $currentEmail)) {
            $result = false;
        } else {
            $result = true;
        }
        return $result;
    }
}
