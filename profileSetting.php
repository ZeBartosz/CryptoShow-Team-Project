<?php
    $title = "Edit your profile";
    $css_file = "./css-files/adminStyle.css";
    $css_filee = "./css-files/header.css";
    include_once "header.php";
    include "profileinfo.php";
    include "profileinfo_contrl.php";
    include "profileinfo_view.php";
    $profileInfo = new ProfileInfoView();


if(isset($_POST["submit"])) {

    $id = $_SESSION["user_id"];

    $nickname = htmlspecialchars($_POST["nickname"], ENT_QUOTES, "UTF-8");
    $name = htmlspecialchars($_POST["name"], ENT_QUOTES, "UTF-8");
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL, );


    include_once "dbh.php";
    include_once "profileinfo.php";
    include_once "profileinfo_contrl.php";
    include_once "profileinfo_view.php";
    $profileInfo = new ProfileInfoContrl($id);

    $profileInfo->updateProfileInfo($nickname, $name, $email);

    header("location: profile.php?error=none");
}
?>
    <section class="profile">
        <div class="profile-bg">
            <div class="wrapper">
                <div class="profile-settings">
                    <h3>PROFILE SETTINGS</h3>
                    <form class="edit-form" method="post">
                        <P>Change your nickname!</P>
                        <input type="text" name="nickname" placeholder="User nickname..." value="<?php $profileInfo->fetchNickname($_SESSION["user_id"])?>">
                        <p>Change your name!</p>
                        <input type="text" name="name" placeholder="User name..." value="<?php $profileInfo->fetchName($_SESSION["user_id"])?>">
                        <p>Change your email!</p>
                        <input type="text" name="email" placeholder="User email..." value="<?php $profileInfo->fetchEmail($_SESSION["user_id"])?>">
                        <button type="submit" name="submit">SAVE</button>
                    </form>
                </div>
            </div>
        </div>
    </section>


</body>
</html>
