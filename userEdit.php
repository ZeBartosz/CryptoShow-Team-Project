<?php
$title = "Edit user";
$css_file = "./css-files/dashboardStyle.css";
include_once "header.php";
require_once "validateAdmin.php";
include "db_connect.php";
include_once "userController.php";

$controller = new UserController();
if(isset($_GET["id"])) {
    $user_id = $_GET["id"];
    $user_info = $controller->getUserInfo($user_id);
    if(!$user_info) {
        $_SESSION["message"] = "Invalid user ID";
        header("location: ./admin.php?tab=users");
        exit();
    }
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST["userid"];
    $username = $_POST["username"];
    $fullname = $_POST["fullname"];
    $email = $_POST["email"];
    $is_admin = isset($_POST["admin"])? 1 : 0;
    $controller = new UserController();
    $result = $controller->setUserInfo($user_id, $username, $fullname, $email, $is_admin);

    if($result === true) {
        $_SESSION["message"] = "Successfully edited user information";
        header("location: ./admin.php?tab=users");
        exit();
    } else {
        header("location: ./admin.php?tab=users");
        $_SESSION["message"] = "Error updating user information";
    }
}
?>
<?php if(isset($_SESSION["message"])) { ?>
    <h5><?= $_SESSION["message"] ?></h5> <?php
    unset($_SESSION["message"]);
} ?>
<form method="post">
    <input type="hidden" value="<?= $user_info["user_id"] ?>" name="userid">
    <div>
        <label>Username</label>
        <input type="text" value="<?= $user_info["user_nickname"] ?>" name="username">
    </div>
    <div>
        <label>Full name</label>
        <input type="text" value="<?= $user_info["user_name"] ?>" name="fullname">
    </div>
    <div>
        <label>Email</label>
        <input type="email" value="<?= $user_info["user_email"] ?>" name="email">
    </div>
    <div>
        <label>Promote to Admin</label>
        <input type="checkbox"  <?php if($user_info["is_admin"]) echo "checked"; ?> name="admin">
    </div>
    <button type="submit" name="submit">Update User</button>
</form>
<a href="./admin.php?tab=users"><button>Cancel</button></a>
<?php
include_once "footer.php";
?>
</body>

</html>
