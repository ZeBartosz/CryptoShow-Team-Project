<?php
    session_start();
    echo "found id" . $_SESSION['user_id'];
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
    <h1>CryptoShow</h1>
    <nav>
        <ul>
            <li><a href="#">Lorem</a></li>
            <li><a href="#">Quis</a></li>
            <li><a href="#">Fugiat</a></li>
            <li><a href="#">Deleniti</a></li>
            <li><a href="#">Ipsum</a></li>
            <li><a href="#">Profiles</a></li>
        </ul>
    </nav>
    <a href=../login.html>
        <form action="logout.php" method="post">
            <button type="submit">Logout</button>
        </form>
    </a>
</header>

<section>
    <h1>User nickname: <?php $profileInfo->fetchNickname($_SESSION["user_id"])?></h1>
    <p>User name: <?php $profileInfo->fetchName($_SESSION["user_id"])?></p>
    <p>User email: <?php $profileInfo->fetchEmail($_SESSION["user_id"])?></p>
    <p>User device count: 0</p>



</section>


</body>
</html>