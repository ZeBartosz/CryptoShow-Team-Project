<?php

require_once "dbh.php";
class UserModel extends Dbh {

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
}
