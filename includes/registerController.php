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
            header("location: registerPage.php?error=emptyinput");
            exit();
        }
        if($this->invalidUsername() == false) {
            header("location: registerPage.php?error=invalidusername");
            exit();
        }
        if($this->invalidName() == false) {
            header("location: registerPage.php?error=invalidname");
            exit();
        }
        if($this->invalidEmail() == false) {
            header("location: registerPage.php?error=invalidemail");
            exit();
        }
        if($this->pwdMatch() == false) {
            header("location: registerPage.php?error=passwordnotmatch");
            exit();
        }
        if($this->userCheckTaken() == false) {
            header("location: registerPage.php?error=usernameoremailexists");
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
