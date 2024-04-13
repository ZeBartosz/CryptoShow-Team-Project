<?php


class ProfileController extends ProfileModel
{

    private $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    public function updateProfileInfo($userNickname, $userName, $userEmail, $pwd, $repeatPwd)
    {
        if ($this->emptyInputCheck($userNickname, $userName, $userEmail)) {
            header("location: ../profile.php?error=emptyinput");
            exit();
        }


        if (!$this->invalidUsername($userNickname)) {
            header("location: ../profile.php?error=invalidUsername");
            exit();
        }

        if (!$this->invalidName($userName)) {
            header("location: ../profile.php?error=invalidName");
            exit();
        }

        if (!$this->invalidEmail($userEmail)) {
            header("location: ../profile.php?error=invalidEmail");
            exit();
        }

        if (!$this->pwdMatch($pwd, $repeatPwd)) {
            header("location: ../profile.php?error=");
            exit();
        }





        $this->setNewProfileInfo($this->userId, $userNickname, $userName, $userEmail, $pwd);

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





}
