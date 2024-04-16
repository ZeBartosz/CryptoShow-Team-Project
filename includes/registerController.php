<?php

include_once "registerModel.php";
/**
 * RegisterController handles the user registration process.
 * This class extends RegisterModel and is responsible for managing user registration,
 * including input validation and creating new user records in the database. It checks
 * for input errors such as empty fields, invalid usernames, names, or emails, mismatched
 * passwords, and whether the username or email is already taken.
 */
class registerController extends RegisterModel {

    private $userNickname;
    private $userName;
    private $pwd;
    private $repeatPwd;
    private $email;

    /**
     * Constructs a new registerController instance with user credentials.
     *
     * @param string $userNickname The nickname of the user.
     * @param string $userName The full name of the user.
     * @param string $pwd The password of the user.
     * @param string $repeatPwd The repeated password for confirmation.
     * @param string $email The email of the user.
     */
    public function __construct($userNickname, $userName, $pwd, $repeatPwd, $email) {
        $this->userNickname = $userNickname;
        $this->userName = $userName;
        $this->pwd = $pwd;
        $this->repeatPwd = $repeatPwd;
        $this->email = $email;
    }

    /**
     * Processes user registration.
     *
     * Validates user input and registers the user if all validations pass.
     * Redirects and sets session error messages on failure.
     */
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

    /**
     * Checks if any registration input field is empty.
     *
     * @return bool Returns true if all fields are filled, false if any are empty.
     */
    private function emptyInput(){
        $result;
        if(empty($this->userNickname) || empty($this->userName) || empty($this->pwd) || empty($this->repeatPwd) || empty($this->email)) {
            $result = false;
        } else {
            $result = true;
        }
        return $result;
    }

    /**
     * Validates the username against a regular expression.
     *
     * @return bool Returns true if the username is valid, false otherwise.
     */
    private function invalidUsername() {
        $result;
        if(!preg_match("/^[a-zA-Z-0-9]*$/", $this->userNickname)) {
            $result = false;
        } else {
            $result = true;
        }
        return $result;
    }    

    /**
     * Validates the name against a regular expression.
     *
     * @return bool Returns true if the name is valid, false otherwise.
     */
    private function invalidName() {
        $result;
        if(!preg_match("/^[a-zA-Z]+(\s[a-zA-Z]+)$/", $this->userName)) {
            $result = false;
        } else {
            $result = true;
        }
        return $result;
    }

    /**
     * Validates the email using a filter.
     *
     * @return bool Returns true if the email is valid, false otherwise.
     */
    private function invalidEmail() {
        $result;
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $result = false;
        } else {
            $result = true;
        }
        return $result;
    }

    /**
     * Checks if the entered passwords match.
     *
     * @return bool Returns true if passwords match, false if they do not.
     */
    private function pwdMatch() {
        $result;
        if($this->pwd !== $this->repeatPwd) {
            $result = false;
        } else {
            $result = true;
        }
        return $result;
    }

    /**
     * Checks if the username or email is already taken.
     *
     * @return bool Returns true if neither the username nor email is taken, false if either is taken.
     */
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
