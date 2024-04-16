<?php

include "loginModel.php";

/**
 * LoginController handles the user authentication process.
 * 
 * This class extends LoginModel and is responsible for managing the user login process,
 * including validating input fields and initiating the authentication check.
 */
class LoginController extends LoginModel {
    private $userNickname;
    private $pwd;

    /**
     * Constructs a new LoginController instance with user credentials.
     *
     * @param string $userNickname The nickname of the user attempting to log in.
     * @param string $pwd The password of the user.
     */
    public function __construct($userNickname, $pwd) {
        $this->userNickname = $userNickname;
        $this->pwd = $pwd;
    }

    /**
     * Attempts to log in a user with the provided credentials.
     *
     * Checks for empty input fields and, if validation passes, proceeds to authenticate the user
     * through the getUser method from the LoginModel. Sets an error message in the session if
     * inputs are empty.
     */
    public function loginUser() {
        if(!$this->emptyInput() == false) {
            $_SESSION["message"] = "Empty input";
        }
        $this->getUser($this->userNickname, $this->pwd);
    }

    /**
     * Checks if the necessary input fields are empty.
     *
     * @return bool True if either nickname or password is empty, false otherwise.
     */
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
