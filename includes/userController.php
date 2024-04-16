<?php

include_once "userModel.php";


/**
 * The controller part of the MVC pattern, handling user-related operations.
 *
 * This class manages interactions between the view layer and the model,
 * handling business logic and application rules related to user data.
 */
class UserController extends UserModel
{

    private $model;

    /**
     * Constructs the UserController by initializing a new UserModel.
     */
    public function __construct()
    {
        $this->model = new UserModel();
    }
    
    /**
     * Retrieves information for a specific user by their user ID.
     *
     * @param int $user_id The user ID for the user to retrieve information.
     * @return array|null The user information array or null if an error occurs.
     */
    public function getUserInfo($user_id)
    {
        try {
            return $this->model->getUserInfo($user_id);
        } catch (PDOException $e) {
            $_SESSION["message"] = "Error fetching user info: " . $e->getMessage();
        }
    }

    /**
     * Retrieves foreign user information by user ID.
     *
     * @param int $user_id The user ID for the foreign user to retrieve information.
     * @return array|null The foreign user information array or null if an error occurs.
     */
    public function getForeignUserInfo($user_id)
    {
        try {
            return $this->model->getForeignUserInfo($user_id);
        } catch (PDOException $e) {
            $_SESSION["message"] = "Error fetching all user info: " . $e->getMessage();
        }
    }
    
    /**
     * Checks if a user is attending a specific event.
     *
     * @param int $user_id The user's ID to check.
     * @param int $event_id The event's ID to check against.
     * @return bool Returns true if attending, false otherwise.
     */
    public function isAttending($user_id, $event_id)
    {
        try {
            return $this->model->isAttending($user_id, $event_id);
        } catch (PDOException $e) {
            $_SESSION["message"] = "Error fetching all attendance: " . $e->getMessage();
        }
    }

    /**
     * Retrieves all users attending a given event.
     *
     * @param int $event_id The event ID to get attendees for.
     * @return array An array of user information for those attending the event.
     */
    public function getAllAttendingUsers($event_id)
    {
        try {
            return $this->model->fetchAllAttendingUsers($event_id);
        } catch (PDOException $e) {
            $_SESSION["message"] = "Error fetching all user info: " . $e->getMessage();
        }
    }

    /**
     * Deletes a user's information from the database.
     *
     * @param int $user_id The user ID of the user to delete.
     */
    public function deleteUserInfo($user_id)
    {
        $this->model->deleteUserInfo($user_id);
    }

    /**
     * Retrieves all user information from the database.
     *
     * @return array An array containing all registered users' information.
     */
    public function getAllUserInfo()
    {
        try {
            return $this->model->fetchAllUserInfo();
        } catch (PDOException $e) {
            $_SESSION["message"] = "Error fetching all user info: " . $e->getMessage();
        }
    }

    /**
     * Searches for users by a specific keyword.
     *
     * @param string $search_keyword The keyword to search for in user attributes.
     * @return array An array of users that match the search criteria.
     */
    public function searchUserByKeyword($search_keyword)
    {
        try {
            return $this->model->searchUserByKeyword($search_keyword);
        } catch (PDOException $e) {
            $_SESSION["message"] = "Error searching user info: " . $e->getMessage();
            header("Location: admin.php?tab=users");
            exit();
        }
    }

    /**
     * Inputs or updates user information based on given parameters after validation checks.
     *
     * Handles user input errors, validation of inputs, and updates the user information in the database.
     *
     * @param int $user_id The ID of the user.
     * @param string $username The desired username.
     * @param string $fullname The full name of the user.
     * @param string $email The email address of the user.
     * @param int $is_admin Whether the user has admin privileges.
     * @param string $currentUsername The current username of the user.
     * @param string $currentEmail The current email of the user.
     * @return bool|array Returns false if any validation fails, otherwise returns an array of updated user info.
     */
    public function inputUserInfo($user_id, $username, $fullname, $email, $is_admin, $currentUsername, $currentEmail)
    {
        $result = $this->hasEmptyInput($username, $fullname, $email);
        if ($result === true) {
            $_SESSION["message"] = "Error Empty Input";
            header("location: ./userEdit.php?id=$user_id");
            exit();
        }

        $result = $this->isValidFullname($fullname);
        if ($result === false) {
            $_SESSION["message"] = "Error Invalid Full name";
            header("location: ./userEdit.php?id=$user_id");
            exit();
        }

        $result = $this->isValidUsername($username);
        if ($result === false) {
            $_SESSION["message"] = "Error Invalid Username";
            header("location: ./userEdit.php?id=$user_id");
            exit();
        }

        $result = $this->isValidEmail($email);
        if ($result === false) {
            $_SESSION["message"] = "Error Invalid Email";
            header("location: ./userEdit.php?id=$user_id");
            exit();
        }

        $result = $this->isValidAdmin($is_admin);
        if ($result === false) {
            $_SESSION["message"] = "Error Invalid Admin Promotion";
            header("location: ./userEdit.php?id=$user_id");
            exit();
        }

        if ($this->userNicknameTaken($username, $currentUsername)) {
            $_SESSION["message"] = "Error Username taken";
            header("location: ./userEdit.php?id=$user_id");
            exit();
        }

        if ($this->userEmailTaken($email, $currentEmail)){
            $_SESSION["message"] = "Error Email taken";
            header("location: ./userEdit.php?id=$user_id");
            exit();
        }
        var_dump($username);
        var_dump($currentUsername);
        return $this->model->setUserInfo($user_id, $username, $fullname, $email, $is_admin);
    }

    /**
     * Checks if any of the given input fields are empty.
     *
     * @param string $username The username to check.
     * @param string $fullname The fullname to check.
     * @param string $email The email address to check.
     * @return bool Returns true if any field is empty, otherwise false.
     */
    private function hasEmptyInput($username, $fullname, $email)
    {
        $result;
        if (empty($username) || empty($fullname) || empty($email)) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    /**
     * Validates the email format.
     *
     * @param string $email The email to validate.
     * @return bool Returns true if the email is valid according to the FILTER_VALIDATE_EMAIL filter, otherwise false.
     */
    private function isValidEmail($email)
    {
        $result;
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    /**
     * Validates the format of the full name.
     *
     * The name should consist of at least two words separated by a space, each starting with an alphabet.
     *
     * @param string $fullname The full name to validate.
     * @return bool Returns true if the full name is valid, otherwise false.
     */
    private function isValidFullname($fullname)
    {
        $result;
        if (preg_match("/^[a-zA-Z]+(\s[a-zA-Z]+)$/", $fullname)) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    /**
     * Validates the username format.
     *
     * A valid username consists only of letters, digits.
     *
     * @param string $username The username to validate.
     * @return bool Returns true if the username is valid, otherwise false.
     */
    private function isValidUsername($username)
    {
        $result;
        if (preg_match("/^[a-zA-Z-0-9]*$/", $username)) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    /**
     * Validates if the is_admin flag is either 1 (true) or 0 (false).
     *
     * @param int $is_admin The admin flag to validate.
     * @return bool Returns true if valid, otherwise false.
     */
    private function isValidAdmin($is_admin)
    {
        $result;
        if ($is_admin === 1 || $is_admin === 0) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    /**
     * Checks if a username is already taken, excluding the current user's username.
     *
     * @param string $username The new username to check.
     * @param string $currentUsername The current username to exclude from the check.
     * @return bool Returns true if the username is taken, otherwise false.
     */
    private function userNicknameTaken ($username, $currentUsername) {
        $result;
        if($this->CheckUsername($username, $currentUsername)){
            $result = false;
        } else {
            $result = true;
        }
        return $result;

    }

    /**
     * Checks if an email is already taken, excluding the current user's email.
     *
     * @param string $email The new email to check.
     * @param string $currentEmail The current email to exclude from the check.
     * @return bool Returns true if the email is taken, otherwise false.
     */
    private function userEmailTaken ($email, $currentEmail){
        $result;
        if($this->CheckEmail($email, $currentEmail)) {
            $result = false;
        } else {
            $result = true;
        }
        return $result;
    }
}
