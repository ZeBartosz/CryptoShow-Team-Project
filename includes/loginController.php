<?php

include "loginModel.php";
class LoginController extends LoginModel {
    private $userNickname;
    private $pwd;

    public function __construct($userNickname, $pwd) {
        $this->userNickname = $userNickname;
        $this->pwd = $pwd;
    }

    public function loginUser() {
        if(!$this->emptyInput() == false) {
            $_SESSION["message"] = "Empty input";
        }
        $this->getUser($this->userNickname, $this->pwd);
    }

    private function emptyInput(){
        $result;
        if(empty($this->userNickname) || empty($this->pwd)) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }
}
