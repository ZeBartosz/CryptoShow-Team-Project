<?php

include_once "userModel.php";

class UserController extends UserModel {

    private $model;

    public function __construct() {
        $this->model = new UserModel();
    }

    public function getUserInfo($user_id) {
        try {
            return $this->model->getUserInfo($user_id);
        } catch (PDOException $e) {
            $_SESSION["message"] = "Error fetching user info: " . $e->getMessage();
        }
    }

    public function getAllUserInfo() {
        try {
            return $this->model->getAllUserInfo();
        } catch (PDOException $e) {
            $_SESSION["message"] = "Error fetching all user info: " . $e->getMessage();
        }
    }

    public function searchUserByKeyword($search_keyword) {
        try {
            return $this->model->searchUserByKeyword($search_keyword);
        } catch (PDOException $e) {
            $_SESSION["message"] = "Error searching user info: " . $e->getMessage();
            header("Location: admin.php?tab=users");
            exit();
        }
    }

    public function setUserInfo($user_id, $username, $fullname, $email, $is_admin)
    {
        $result = $this->hasEmptyInput($username, $fullname, $email);
        if($result === true) {
            $_SESSION["message"] = "Error Empty Input";
            header("location: ./userEdit.php?id=$user_id");
            exit();
        }

        $result = $this->isValidFullname($fullname);
        if($result === false) {
            $_SESSION["message"] = "Error Invalid Full name";
            header("location: ./userEdit.php?id=$user_id");
            exit();
        }

        $result = $this->isValidUsername($username);
        if($result === false) {
            $_SESSION["message"] = "Error Invalid Username";
            header("location: ./userEdit.php?id=$user_id");
            exit();
        }

        $result = $this->isValidEmail($email);
        if($result === false) {
            $_SESSION["message"] = "Error Invalid Email";
            header("location: ./userEdit.php?id=$user_id");
            exit();
        }

        $result = $this->isValidAdmin($is_admin);
        if($result === false) {
            $_SESSION["message"] = "Error Invalid Admin Promotion";
            header("location: ./userEdit.php?id=$user_id");
            exit();
        }

        return $this->model->setUserInfo($user_id, $username, $fullname, $email, $is_admin);
    }

    private function hasEmptyInput($username, $fullname, $email) {
        $result;
        if(empty($username) || empty($fullname) || empty($email)) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    private function isValidEmail($email) {
        $result;
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    private function isValidFullname($fullname) {
        $result;
        if(preg_match("/^[a-zA-Z]+(\s[a-zA-Z]+)$/", $fullname)) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    private function isValidUsername($username) {
        $result;
        if(preg_match("/^[a-zA-Z-0-9]*$/", $username)) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    private function isValidAdmin($is_admin) {
        $result;
        if($is_admin === 1 || $is_admin === 0) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }
}