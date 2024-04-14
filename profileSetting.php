<?php

    ini_set("file_upload", "On");
    $title = "Edit your profile";
    $css_file = "./css-files/header.css";
    $css_filee = "./css-files/profileStyle.css";
    include_once "header.php";
    include_once "profileModel.php";
    include_once "profileController.php";
    include_once "profileView.php";
    require_once "validateSession.php";
    isNotLoggedIn();
    $profileInfo = new ProfileView();

if(isset($_POST["submit"])) {

    $id = $_SESSION["user_id"];

    $nickname = $_POST["nickname"];
    $name = $_POST["name"];
    $email = $_POST["email"];
    $bio = $_POST["description"];
    $pwd = $_POST["password"];
    $repeatPwd = $_POST["rptPassword"];

    $fileName = $_FILES["image"]["name"];
    $fileExt = explode('.', $fileName);
    $actualFileExt = strtolower(end($fileExt));
    $allowed = array('jpg', 'jpeg', 'png');

    if (!in_array($actualFileExt, $allowed)){
        header("location: {$_SERVER['PHP_SELF']}");
        $_SESSION["message"] = "Error wrong image compression";
        exit();

    }

    if($_FILES["image"]["error"] == 1){
        header("location: {$_SERVER['PHP_SELF']}");
        $_SESSION["message"] = "Error with the image";
        exit();

    }

    if ($_FILES["image"]["size"] > 200000000 ){
        header("location: {$_SERVER['PHP_SELF']}");
        $_SESSION["message"] = "Error image too large ";
        exit();
    }


    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $count = "1";
    while (file_exists($target_file)) {
        $target_file = $target_dir . $count . basename($_FILES["image"]["name"]);
        $count++;
    }

    move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

    include_once "dbh.php";

    $profileInfo = new ProfileController($id);

    $profileInfo->updateProfileInfo($nickname, $name, $email, $pwd, $repeatPwd, $target_file, $bio);

    header("location: profile.php?error=none");
}

?>
    <section class="profile">
        <div class="profile-bg">
            <div class="wrapper">
                <div class="profile-settings">
                    <h3>PROFILE SETTINGS</h3>
                    <form class="edit-form" method="post" enctype="multipart/form-data">
                        <label for="nickname">Change Nickname:</label>
                        <input type="text" name="nickname" placeholder="User nickname..." value="<?php $profileInfo->fetchNickname($_SESSION["user_id"])?>">
                        <label for="name">Change Name:</label>
                        <input type="text" name="name" placeholder="User name..." value="<?php $profileInfo->fetchName($_SESSION["user_id"])?>">
                        <label for="email">Change Email:</label>
                        <input type="text" name="email" placeholder="User email..." cccc">
                        <label for="image">Profile Image:</label>
                        <input type="file" name="image" placeholder="Avatar...">
                        <label for="description">Change Bio:</label>
                        <textarea name="description" placeholder="Wrtie a bio... (max 255 char)" value="" rows="4" cols="37"><?php $profileInfo->fetchBio($_SESSION["user_id"])?></textarea>
                        <label for="password">Change Password:</label>
                        <input type="password" id="password" name="password" placeholder="Password">
                        <label for="rptPassword">Repeat Password:</label>
                        <input type="password" id="rptPassword" name="rptPassword"placeholder="Repeat password">
                        <button type="submit" name="submit">SAVE</button>
                    </form>
                </div>
            </div>
        </div>
    </section>


</body>
</html>
