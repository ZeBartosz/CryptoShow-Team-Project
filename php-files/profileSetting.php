<?php
    session_start();
    include "profileinfo.php";
    include "profileinfo_contrl.php";
    include "profileinfo_view.php";
    $profileInfo = new ProfileInfoView();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css-files/IndexStyle.css">
    <title>Profile</title>
</head>
<body>
<header>

    <section class="profile">
        <div class="profile-bg">
            <div class="wrapper">
                <div class="profile-settings">
                    <h3>PROFILE SETTINGS</h3>
                    <form action="profileSettingProcess.php" method="post">
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