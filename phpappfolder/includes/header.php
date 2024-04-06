<?php
session_start();

if(isset($_GET['logout'])) {
    if($_GET["logout"] == "true") {
        session_unset();
        session_destroy();
        header("location: index.php");

        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title;?></title>
    <link rel="stylesheet" href="<?php echo $css_file ?>">
    <script src="./Js-Files/carousel.js" defer></script>
    <script src="./Js-Files/adminTabs.js" defer></script>
    </head>
<body>
<header>
    <a class="logo" href="index.php"><h1>CryptoShow</h1></a>
    <ul>
        <?php
        if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']) {
            echo  "<li><a class='headerBtn' href='./admin.php'>Admin</a></li>";
        }
        ?>
        <?php
        if (isset($_SESSION['user_id'] )) {
            echo  "<li><a class='headerBtn' href='./profile.php'>Profile</a></li>";
            echo "<li><a class='headerBtn' href='index.php?logout=true'>Logout</a></button></li>";
        } else {
          echo  "<li><a class='headerBtn' href='register.php'>Register</a></li>";
          echo  "<li><a class='headerBtn' href='login.php'>Login</a></li>";
        }
        ?>

    </ul>

</header>
