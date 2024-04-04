<?php
$title = "Register here!";
$css_file = "./css-files/dashboardStyle.css";
include_once "header.php";
?>
<div class="body">
    <form action="php-files/registerProcess.php" method="post">
        <label for="username">Username or Email:</label><br>
        <input type="text" id="username" name="username"><br>
        <div>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name">
            <label for="lastname">Lastname:</label>
            <input type="text" id="lastname" name="lastname">
        </div>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password"><br><br>
        <label for="rptPassword">Repeat Password:</label><br>
        <input type="password" id="rptPassword" name="rptPassword"><br><br>
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email"><br><br>
        <input type="submit" name="submit">
    </form>
    <a href="./login.php">Log in here if you have an account</a>
</div>
</body>
</html>
