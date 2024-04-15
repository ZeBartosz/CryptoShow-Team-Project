<?php

include_once "deviceModel.php";
class ProfileController extends ProfileModel
{

    private $userId;
    private $model;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }


    public function updateProfileInfo($userNickname, $userName, $userEmail, $pwd, $repeatPwd, $image, $bio, $currentNickname, $currentEmail)
    {
        
        if ($this->emptyInputCheck($userNickname, $userName, $userEmail)) {
            $_SESSION["message"] = "Error: Empty input ";
            header("location: {$_SERVER['PHP_SELF']}");
            exit();
        }


        if (!$this->invalidUsername($userNickname)) {
            $_SESSION["message"] = "Error: Invalid nickname";
            header("location: {$_SERVER['PHP_SELF']}");
            exit();
        }

        if (!$this->reachedDescriptionLimit($bio)) {
            $_SESSION["message"] = "Error: Description limit";
            header("location: {$_SERVER['PHP_SELF']}");
            exit();
        }

        if (!$this->invalidName($userName)) {
            $_SESSION["message"] = "Error: Invalid name";
            header("location: {$_SERVER['PHP_SELF']}");
            exit();
        }

        if (!$this->invalidEmail($userEmail)) {
            $_SESSION["message"] = "Error: Invalid email";
            header("location: {$_SERVER['PHP_SELF']}");
            exit();
        }

        if (!$this->pwdMatch($pwd, $repeatPwd)) {
            $_SESSION["message"] = "Error: Password not matching";
            header("location: {$_SERVER['PHP_SELF']}");
            exit();
        }

        if ($this->userNicknameTaken($userNickname, $currentNickname)) {
            $_SESSION["message"] = "Error: User nickname already taken ";
            header("location: {$_SERVER['PHP_SELF']}");
            exit();
        }

        if ($this->userEmailTaken($userEmail, $currentEmail)){
            $_SESSION["message"] = "Error: Email already taken ";
            header("location: {$_SERVER['PHP_SELF']}");
            exit();
        }

        $this->setNewProfileInfo($this->userId, $userNickname, $userName, $userEmail, $pwd, $image, $bio);

    }

    public function updateDeviceCount($deviceCount){

        $this->setDeviceCount($this->userId, $deviceCount);

    }

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

    private function invalidUsername($userNickname) {
        $result;
        if(!preg_match("/^[a-zA-Z-0-9]*$/", $userNickname)) {
            $result = false;
        } else {
            $result = true;
        }
        return $result;
    }

    private function invalidName($userName) {
        $result;
        if(!preg_match("/^[a-zA-Z]+(\s[a-zA-Z]+)$/", $userName)) {
            $result = false;
        } else {
            $result = true;
        }
        return $result;
    }

    private function invalidEmail($userEmail) {
        $result;
        if (!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
            $result = false;
        } else {
            $result = true;
        }
        return $result;
    }

    private function pwdMatch($pwd, $repeatPwd) {
        $result;
        if($pwd !== $repeatPwd) {
            $result = false;
        } else {
            $result = true;
        }
        return $result;
    }

    private function reachedDescriptionLimit($event_description) {
        $result;
        if(strlen($event_description) > 255) {
            $result = false;
        } else {
            $result = true;
        }
        return $result;
    }

    private function userNicknameTaken ($userNickname, $currentNickname) {
        $result;
        if($this->CheckUsername($userNickname, $currentNickname)){
            $result = false;
        } else {
            $result = true;
        }
        return $result;

    }

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
