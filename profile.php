<?php
$title = "Profile page";
$css_file = "./css-files/dashboardStyle.css";
include_once "header.php";
include "profileinfo.php";
include "profileinfo_contrl.php";
include "profileinfo_view.php";
$profileInfo = new ProfileInfoView()
?>
<section>
    <h1>User nickname: <?php $profileInfo->fetchNickname($_SESSION["user_id"])?></h1>
    <p>User name: <?php $profileInfo->fetchName($_SESSION["user_id"])?></p>
    <p>User email: <?php $profileInfo->fetchEmail($_SESSION["user_id"])?></p>
    <a href="profileSetting.php">Edit Profile</a>
</section>

<section>
    <p>User device count: <?php $profileInfo->fetchDeivceCount($_SESSION["user_id"])?>/5</p>
    <a href="deviceAdd.php">Add Device</a>
</section>

</body>
</html>