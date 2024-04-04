<?php
    $title = "Edit your profile";
    $css_file = "./css-files/dashboardStyle.css";
    include_once "header.php";
    include "profileinfo.php";
    include "profileinfo_contrl.php";
    include "profileinfo_view.php";
    $profileInfo = new ProfileInfoView();
?>
    <section class="profile">
        <div class="profile-bg">
            <div class="wrapper">
                <div class="profile-settings">
                    <h3>PROFILE SETTINGS</h3>
                    <form action="./php-files/profileSettingProcess.php" method="post">
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
