<?php
$title = "Login page";
$css_file = "./css-files/loginStyle.css";
$css_filee ="./css-files/header.css";
include_once "header.php";
require_once "validateSession.php";
require_once "dbh.php";
include_once "loginController.php";
isLoggedIn();
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $userNickname = $_POST["username"];
    $pwd = $_POST["password"];

    $login = new LoginControlLer($userNickname, $pwd);
    $login->loginUser();

    header("location: ./index.php");
}
?>
<main>
    <div class="content">
        <h1>Sign in</h1>
        <p>Sign into your CryptoShow account</p>
        <?php if(isset($_SESSION["message"])) { ?>
            <h5><?= $_SESSION['message'] ?></h5> <?php
            unset($_SESSION["message"]);
        } ?>
        <form method="post">
            <label for="username">Username or Email:</label><br>
            <input type="text" id="username" name="username"placeholder="Username"><br>
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password"placeholder="Password"><br><br>
            <button type="submit" name="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="register.php">Register here</a></p>
    </div>
    </main>
    <?php
    include_once "footer.php";
    ?>
</body>
</html>
