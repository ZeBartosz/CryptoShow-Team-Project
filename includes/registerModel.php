<?php
include_once "dbh.php";
/**
 * RegisterModel manages the database interactions for user registration.
 * 
 * This class extends Dbh (Database Handler), providing specific methods
 * to interact with the database for registering new users, including
 * inserting new user data and checking for existing usernames or emails.
 */
class RegisterModel extends Dbh {

    /**
     * Registers a new user by inserting their details into the database.
     * 
     * This method attempts to insert a new user's nickname, full name, hashed password,
     * and email address into the registered_user table. It hashes the password before
     * storing it. If the insertion fails, it redirects to the registration page with an error.
     *
     * @param string $userNickname The nickname of the user to register.
     * @param string $userName The full name of the user.
     * @param string $pwd The password to be hashed and stored.
     * @param string $email The email address of the user.
     */
    protected function setUser($userNickname, $userName, $pwd, $email) {
        $stmt = $this->connect()->prepare("INSERT INTO registered_user (user_nickname, user_name, user_hashed_password,
        user_email, user_registered_timestamp) VALUES (?, ?, ?, ?, NOW());");



        $hashedPwd = password_hash($pwd,PASSWORD_DEFAULT);

        if(!$stmt->execute(array($userNickname, $userName, $hashedPwd, $email))) {
            $stmt = null;
            header("location: register.php?error=stmtfailed");
            exit();
        }
        $stmt = null;
    }

    /**
     * Checks if a username or email is already taken in the database.
     * 
     * This method queries the registered_user table to see if the given
     * username or email already exists. If either exists, it returns false; otherwise, true.
     *
     * @param string $userNickname The nickname to check against existing records.
     * @param string $email The email to check against existing records.
     * @return bool True if the username and email are both available, false if either is already taken.
     */
    protected function checkUser($userNickname, $email) {
        $stmt = $this->connect()->prepare("SELECT user_nickname FROM registered_user WHERE user_nickname =? 
        OR user_email = ?;");

        if(!$stmt->execute(array($userNickname, $email))) {
            $stmt = null;
            header("location: register.php?error=stmtfailed");
            exit();
        }

        $resultCheck;
        if ($stmt->rowCount() > 0) {
            $resultCheck = false;
        } else {
            $resultCheck = true;
        }
        return $resultCheck;

    }
}
