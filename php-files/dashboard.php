<?php
session_start();

if (isset($_SESSION['user_id']) && isset($_SESSION['username'])) {
} else {
    header("Location: ../login.php");
    session_destroy();
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../css-files/dashboardStyle.css">
</head>
<body>
    <header>
        <h1>CryptoShow</h1>
        <ul>
            <li><a href="./profile.php">Profile</a></li>
        </ul>
        <form action="logout.php" method="post">
            <button type="submit">Logout</button>
        </form>
    </header>
    
</body>
</html>
