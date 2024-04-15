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


    public function updateProfileInfo($userNickname, $userName, $userEmail, $pwd, $repeatPwd, $image, $bio)
    {
        if ($this->emptyInputCheck($userNickname, $userName, $userEmail)) {
            header("location: profile.php?error=emptyinput");
            exit();
        }


        if (!$this->invalidUsername($userNickname)) {
            header("location: profile.php?error=invalidUsername");
            exit();
        }

        if (!$this->reachedDescriptionLimit($bio)) {
            header("location: profile.php?error=DescriptionLimitMet");
            exit();
        }

        if (!$this->invalidName($userName)) {
            header("location: profile.php?error=invalidName");
            exit();
        }

        if (!$this->invalidEmail($userEmail)) {
            header("location: profile.php?error=invalidEmail");
            exit();
        }

        if (!$this->pwdMatch($pwd, $repeatPwd)) {
            header("location: profile.php?error=passwordNotMatching");
            exit();
        }

        if (!$this->userNicknameTaken($userNickname)) {
            header("location: profile.php?error=userNicknameTaken");
            exit();
        }

        if (!$this->userEmailTaken($userEmail)){
            header("location: profile.php?error=userEmailTaken");
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

    private function userNicknameTaken ($userNickname) {
        $result;
        if($this->CheckUsername($userNickname)){
            $result = false;
        } else {
            $result = true;
        }
        return $result;

    }

    private function userEmailTaken ($userEmail){
        $result;
        if($this->CheckEmail($userEmail)) {
            $result = false;
        } else {
            $result = true;
        }
        return $result;
    }





}
