<?php
$title = "Login page";
$css_file = "./css-files/dashboardStyle.css";
include_once "header.php";
?>
    <div class="body">
        <form action="./php-files/loginProcess.php" method="post">
            <label for="username">Username or Email:</label><br>
            <input type="text" id="username" name="username"><br>
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password"><br><br>
            <input type="submit" name="submit">
        </form>
        <a href="./register.php">Register here</a>
    </div>
</body>
</html>
