<?php

require_once "dbh.php";
class UserModel extends Dbh {

    public function deleteUserInfo($user_id)
    {
        try {
            $query = "DELETE FROM registered_user WHERE user_id=:userid";
            $stmt = $this->connect()->prepare($query);
            $stmt->bindParam(":userid", $user_id, PDO::PARAM_INT);

            $stmt->execute();
            header("location: ./admin.php");
            $_SESSION["message"] = "User deleted successfully";
        } catch (PDOException $e) {
            header("location: ./admin.php");
            $_SESSION["message"] = "Error deleting user: " . $e->getMessage();
        }
    }

    public function getUserInfo($user_id) {
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

    public function getAllUserInfo() {
        try {
            $query = "SELECT * FROM registered_user";
            $stmt = $this->connect()->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $_SESSION["message"] = "Error fetching all user info: " . $e->getMessage();
        }
    }

    public function setUserInfo($user_id, $username, $fullname, $email, $is_admin) {
        try {
            $query = "UPDATE registered_user SET user_nickname = :username, user_name = :fullname, user_email = :email, is_admin = :is_admin WHERE user_id = :user_id AND user_nickname = :username";
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
            header("location: ./admin.php");
            exit();
        }
    }




}
