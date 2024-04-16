<?php
    require_once "dbh.php";

/**
 * LoginModel interacts with the database to manage user authentication.
 * 
 * This class extends Dbh (Database Handler) and provides methods specifically
 * for handling user authentication processes, including validating user credentials
 * against the database.
 */
class LoginModel extends Dbh {

    /**
     * Retrieves and validates a user's login credentials against the database.
     * 
     * The method first checks if the user with the given nickname or email exists.
     * If the user exists, it then verifies the password. If the password is correct,
     * it fetches additional user details and sets session variables. If any step fails,
     * it redirects to the login page with an appropriate error message.
     *
     * @param string $userNickname The user's nickname or email used to log in.
     * @param string $pwd The plaintext password provided by the user to log in.
     */
    public function getUser($userNickname, $pwd) {
        $stmt = $this->connect()->prepare('SELECT * FROM registered_user WHERE user_nickname = ? OR user_email = ?;');

        if(!$stmt->execute(array($userNickname, $pwd))) {
            $stmt = null;
            header("location: ./login.php?error=stmtfailed");
            exit();
        }

        if($stmt->rowCount() == 0) {
            $stmt = null;
            $_SESSION["message"] = "User not found";
            header("location: ./login.php");
            exit();
        }

        $pwdHashed = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $checkPwd = password_verify($pwd, $pwdHashed[0]['user_hashed_password']);

        if($checkPwd == false) {
            $stmt = null;
            $_SESSION["message"] = "Wrong password";
            header("location: ./login.php?error=wrongpassword");
            exit();
        } elseif ($checkPwd == true) {
            $stmt = $this->connect()->prepare('SELECT * FROM registered_user WHERE user_nickname = ? OR user_email = ?
            AND user_hashed_password = ?;');


            if(!$stmt->execute(array($userNickname, $userNickname, $pwd))) {
                $stmt = null;
                header("location: ./login.php?error=stmtfailed");
                exit();
            }

            if($stmt->rowCount() == 0) {
                $stmt = null;
                header("location: ./login.php?error=usernotfound");
                exit();
            }

            $user = $stmt->fetchAll(PDO::FETCH_ASSOC);


            session_start();
            $_SESSION["is_admin"] = $user[0]["is_admin"];
            $_SESSION["user_id"] = $user[0]["user_id"];
            $_SESSION["userNickname"] = $user[0]["user_nickname"];

            $stmt = null;

        }
        $stmt = null;
    }
}
