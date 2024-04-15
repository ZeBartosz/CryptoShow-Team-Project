<?php

include_once "registerModel.php";
class registerController extends RegisterModel {

    private $userNickname;
    private $userName;
    private $pwd;
    private $repeatPwd;
    private $email;

    public function __construct($userNickname, $userName, $pwd, $repeatPwd, $email) {
        $this->userNickname = $userNickname;
        $this->userName = $userName;
        $this->pwd = $pwd;
        $this->repeatPwd = $repeatPwd;
        $this->email = $email;
    }

    public function registerUser() {
        if($this->emptyInput() == false) {
            $_SESSION["message"] = "Empty input";
            header("location: register.php?error=emptyinput");
            exit();
        }
        if($this->invalidUsername() == false) {
            $_SESSION["message"] = "Invalid username";
            header("location: register.php?error=invalidusername");
            exit();
        }
        if($this->invalidName() == false) {
            $_SESSION["message"] = "Invalid name";
            header("location: register.php?error=invalidname");
            exit();
        }
        if($this->invalidEmail() == false) {
            $_SESSION["message"] = "Invalid email";
            header("location: register.php?error=invalidemail");
            exit();
        }
        if($this->pwdMatch() == false) {
            $_SESSION["message"] = "Passwords do not match";
            header("location: register.php?error=passwordnotmatch");
            exit();
        }
        if($this->userCheckTaken() == false) {
            $_SESSION["message"] = "Username or Email exists";
            header("location: register.php?error=usernameoremailexists");
            exit();
        }

        $this->setUser($this->userNickname, $this->userName, $this->pwd, $this->email);
    }

    private function emptyInput(){
        $result;
        if(empty($this->userNickname) || empty($this->userName) || empty($this->pwd) || empty($this->repeatPwd) || empty($this->email)) {
            $result = false;
        } else {
            $result = true;
        }
        return $result;
    }

    private function invalidUsername() {
        $result;
        if(!preg_match("/^[a-zA-Z-0-9]*$/", $this->userNickname)) {
            $result = false;
        } else {
            $result = true;
        }
        return $result;
    }

    private function invalidName() {
        $result;
        if(!preg_match("/^[a-zA-Z]+(\s[a-zA-Z]+)$/", $this->userName)) {
            $result = false;
        } else {
            $result = true;
        }
        return $result;
    }

    private function invalidEmail() {
        $result;
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $result = false;
        } else {
            $result = true;
        }
        return $result;
    }

    private function pwdMatch() {
        $result;
        if($this->pwd !== $this->repeatPwd) {
            $result = false;
        } else {
            $result = true;
        }
        return $result;
    }

    private function userCheckTaken() {
        $result;
        if (!$this->checkUser($this->userNickname, $this->email)) {
            $result = false;
        } else {
            $result = true;
        }
        return $result;
    }

}
