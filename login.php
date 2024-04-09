<?php
$title = "Login page";
$css_file = "./css-files/loginStyle.css";
$css_filee ="./css-files/header.css";
include_once "header.php";
?>
    <div class="content">
        <h1>Sign in</h1>
        <p>Sign into your CryptoShow account</p>
        <form action="./php-files/loginProcess.php" method="post">
            <label for="username">Username or Email:</label><br>
            <input type="text" id="username" name="username"placeholder="Username"><br>
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password"placeholder="Password"><br><br>
            <button type="submit" name="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="register.php">Register here</a></p>
    </div>
    <?php
    include_once "footer.php";
    ?>
</body>
</html>