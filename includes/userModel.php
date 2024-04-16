<?php

require_once "dbh.php";

/**
 * Represents the model layer for user data management in the MVC architecture.
 * 
 * This class interacts directly with the database to perform CRUD operations on user data,
 * including retrieval, update, and deletion of user records.
 */
class UserModel extends Dbh {

    /**
     * Deletes a user's information from the database based on the user ID.
     *
     * @param int $user_id The ID of the user to delete.
     * @throws PDOException If there is a database error.
     */
    protected function deleteUserInfo($user_id)
    {
        try {
            $query = "DELETE FROM registered_user WHERE user_id=:userid";
            $stmt = $this->connect()->prepare($query);
            $stmt->bindParam(":userid", $user_id, PDO::PARAM_INT);

            $stmt->execute();
            $_SESSION["message"] = "User deleted successfully";
            header("location: ./admin.php");
        } catch (PDOException $e) {
            header("location: ./admin.php");
            $_SESSION["message"] = "Error deleting user: " . $e->getMessage();
        }
    }

    /**
     * Retrieves detailed information for multiple users based on an array of user IDs.
     *
     * @param array $foreign_user_id An array of foreign user IDs to fetch information for.
     * @return array Returns an associative array of user details.
     * @throws PDOException If there is a database error.
     */
    protected function getForeignUserInfo($foreign_user_id) {
        try {
            $user_id = array_column($foreign_user_id, "fk_user_id");
            $placeholders = implode(',', array_fill(0, count($user_id), "?"));
            $query = "SELECT * FROM registered_user WHERE user_id IN ($placeholders)";
            $stmt = $this->connect()->prepare($query);


            $stmt->execute($user_id);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $_SESSION["message"] = "Error fetching user info: " . $e->getMessage();
        }
    }

    /**
     * Fetches complete information for a user based on their user ID.
     *
     * @param int $user_id The user's ID for which information is being fetched.
     * @return array|null Returns a single user's information or null on failure.
     * @throws PDOException If there is a database error.
     */
    protected function getUserInfo($user_id) {
        try {
            $query = "SELECT * FROM registered_user WHERE user_id = :user_id";
            $stmt = $this->connect()->prepare($query);
            $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);

            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $_SESSION["message"] = "Error fetching user info: " . $e->getMessage();
        }
    }

    /**
     * Checks if a user is attending a specified event.
     *
     * @param int $user_id The user ID to check.
     * @param int $event_id The event ID to check.
     * @return bool Returns true if the user is attending the event, otherwise false.
     * @throws PDOException If there is a database error.
     */
    protected function isAttending($user_id, $event_id) {
        try {
            $query = "SELECT * FROM user_event WHERE fk_user_id=:user_id AND fk_event_id=:event_id";
            $stmt = $this->connect()->prepare($query);
            $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            $stmt->bindParam(":event_id", $event_id, PDO::PARAM_INT);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if($row) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            $_SESSION["message"] = "Error checking attendance: " . $e->getMessage();
        }
    }

    /**
     * Retrieves information for all registered users.
     *
     * @return array An array of all users' information.
     * @throws PDOException If there is a database error.
     */
    protected function fetchAllUserInfo() {
        try {
            $query = "SELECT * FROM registered_user";
            $stmt = $this->connect()->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $_SESSION["message"] = "Error fetching all user info: " . $e->getMessage();
        }
    }

    /**
     * Fetches all users attending a specific event.
     *
     * @param int $event_id The ID of the event to fetch attending users for.
     * @return array An array of user IDs who are attending the specified event.
     * @throws PDOException If there is a database error.
     */
    protected function fetchAllAttendingUsers($event_id) {
        try {
            $query = "SELECT fk_user_id FROM user_event WHERE fk_event_id = ?;";
            $stmt = $this->connect()->prepare($query);

            $stmt->execute(array($event_id));
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }catch (PDOException $e) {
            $_SESSION["message"] = "Error fetching all user info: " . $e->getMessage();
        }
    }

    /**
     * Updates or Adds information for a specific user.
     *
     * @param int $user_id The ID of the user to update.
     * @param string $username The new username.
     * @param string $fullname The full name of the user.
     * @param string $email The email address of the user.
     * @param int $is_admin The admin status (0 or 1).
     * @return bool Returns true on successful update.
     * @throws PDOException If there is a database error.
     */
    protected function setUserInfo($user_id, $username, $fullname, $email, $is_admin) {
        try {
            $query = "UPDATE registered_user SET user_nickname = :username, user_name = :fullname, user_email = :email, is_admin = :is_admin WHERE user_id = :user_id";
            $stmt = $this->connect()->prepare($query);

            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->bindParam(':fullname', $fullname, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':is_admin', $is_admin, PDO::PARAM_INT);
            $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);

            $stmt->execute();
            return true;

        }catch (PDOException $e) {
            $_SESSION["message"] = "Error editing user info: " . $e->getMessage();
            header("location: ./admin.php?tab=users");
            exit();
        }
    }

    /**
     * Searches for users by a keyword in multiple fields such as nickname, name, email, or user ID.
     *
     * @param string $search_keyword The keyword to search for.
     * @return array An array of users that match the keyword.
     * @throws PDOException If there is a database error.
     */
    protected function searchUserByKeyword($search_keyword) {
        try {
            $query = "SELECT * FROM registered_user WHERE user_nickname LIKE :search_keyword OR user_name LIKE :search_keyword OR user_email LIKE :search_keyword OR user_id LIKE :search_keyword";
            $stmt = $this->connect()->prepare($query);

            $stmt->bindParam(":search_keyword", $search_keyword, PDO::PARAM_STR);

            $stmt->execute(["search_keyword" => "%$search_keyword%"]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $_SESSION["message"] = "Error searching user info: " . $e->getMessage();
            header("location: ./admin.php?tab=users");
            exit();
        }
    }

    /**
     * Checks if a username is already taken, excluding the current user's username to allow updates.
     *
     * @param string $username The username to check.
     * @param string $currentUsername The current username of the user, to exclude from the check.
     * @return bool Returns true if the username is available, false if it is taken.
     */
    protected function CheckUsername($username, $currentUsername) {
        $stmt = $this->connect()->prepare("SELECT user_nickname FROM registered_user WHERE user_nickname = ?;");

        if(!$stmt->execute(array($username))) {
            $stmt = null;
            header("location: admin.php?error=stmtfailed");
            exit();
        }
        $nickname = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($currentUsername === $nickname["user_nickname"]) {
            return true;
        } else {
            $resultCheck;
            if ($stmt->rowCount() > 0) {
                $resultCheck = false;
            } else {
                $resultCheck = true;
            }
            return $resultCheck;
        }
    }

      /**
     * Checks if an email address is already in use, excluding the current user's email to allow updates.
     *
     * @param string $email The email to check.
     * @param string $currentEmail The current email of the user, to exclude from the check.
     * @return bool Returns true if the email is available, false if it is taken.
     */
    protected function CheckEmail($email, $currentEmail) {
        $stmt = $this->connect()->prepare("SELECT user_email FROM registered_user WHERE user_email = ?;");

        if(!$stmt->execute(array($email))) {
            $stmt = null;
            header("location: admin.php?error=stmtfailed");
            exit();
        }

        $email = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($currentEmail === $email["user_email"]) {
            return true;
        } else {
            $resultCheck;
            if ($stmt->rowCount() > 0) {
                $resultCheck = false;
            } else {
                $resultCheck = true;
            }
            return $resultCheck;
        }
    }
}
