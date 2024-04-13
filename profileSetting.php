<?php
    $title = "Edit your profile";
    $css_file = "./css-files/dashboardStyle.css";
    include_once "header.php";
    include_once "profileModel.php";
    include_once "profileController.php";
    include_once "profileView.php";
    $profileInfo = new ProfileView();

if(isset($_POST["submit"])) {

    $id = $_SESSION["user_id"];

    $nickname = $_POST["nickname"];
    $name = $_POST["name"];
    $email = $_POST["email"];
    $pwd = $_POST["password"];
    $repeatPwd = $_POST["rptPassword"];

    include_once "dbh.php";

    $profileInfo = new ProfileController($id);

    $profileInfo->updateProfileInfo($nickname, $name, $email, $pwd, $repeatPwd);

    header("location: profile.php?error=none");
}
?>
    <section class="profile">
        <div class="profile-bg">
            <div class="wrapper">
                <div class="profile-settings">
                    <h3>PROFILE SETTINGS</h3>
                    <form class="edit-form" method="post">
                        <label for="nickname">Change Nickname:</label>
                        <input type="text" name="nickname" placeholder="User nickname..." value="<?php $profileInfo->fetchNickname($_SESSION["user_id"])?>">
                        <label for="name">Change Name:</label>
                        <input type="text" name="name" placeholder="User name..." value="<?php $profileInfo->fetchName($_SESSION["user_id"])?>">
                        <label for="email">Change Email:</label>
                        <input type="text" name="email" placeholder="User email..." value="<?php $profileInfo->fetchEmail($_SESSION["user_id"])?>">
                        <label for="password">Change Password:</label>
                        <input type="password" id="password" name="password"placeholder="Password">
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
