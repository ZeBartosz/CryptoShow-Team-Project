<?php

    ini_set("file_upload", "On");
    $title = "Edit your profile";
    $css_file = "./css-files/header.css";
    $css_filee = "./css-files/adminStyle.css";
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

    if($_FILES["image"]["error"] == 4 ){
        $target_file = $profileInfo->fetchImage($id);
    } else {
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
    }


    include_once "dbh.php";

    $currentNickname = $profileInfo->fetchNickname($_SESSION["user_id"]);
    $currentEmail = $profileInfo->fetchEmail($_SESSION["user_id"]);

    $profileInfo = new ProfileController($id);

    $profileInfo->updateProfileInfo($nickname, $name, $email, $pwd, $repeatPwd, $target_file, $bio, $currentNickname, $currentEmail);

    header("location: profile.php?error=none");
}

?>
    <section class="profile">
        <div class="profile-bg">
            <div class="wrapper">
                <div class="profile-settings">
                    <form class="edit-form" method="post" enctype="multipart/form-data">
                        <h3>PROFILE SETTINGS</h3>
                        <label for="nickname">Change Nickname:</label>
                        <input type="text" name="nickname" placeholder="User nickname..." value="<?= $profileInfo->fetchNickname($_SESSION["user_id"])?>" required>
                        <label for="name">Change Name:</label>
                        <input type="text" name="name" placeholder="User name..." value="<?php $profileInfo->fetchName($_SESSION["user_id"])?>" required>
                        <label for="email">Change Email:</label>
                        <input type="text" name="email" placeholder="User email..." value="<?= $profileInfo->fetchEmail($_SESSION["user_id"])?>" required>
                        <label for="image">Profile Image: max 2mb</label>
                        <input type="file" name="image" placeholder="Avatar...">
                        <label for="description">Change Bio:</label>
                        <textarea name="description" maxlength="255" placeholder="Write a bio... (max 255 char)" value="" rows="4" cols="37"><?= $profileInfo->fetchBio($_SESSION["user_id"])?></textarea>
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
    <?php
    include_once "footer.php";
    ?>


</body>
</html>
