<?php
$title = "Register here!";
$css_file = "./css-files/registerStyle.css";
$css_filee = "./css-files/header.css";
include_once "header.php";
?>
<div class="body">
<h1>Create an account</h1>
        <p>Create a CryptoShow Account</p>
    <form action="php-files/registerProcess.php" method="post">
        <label for="username">Username or Email:</label>
        <input type="text" id="username" name="username"
        placeholder="Username">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" placeholder="Firstname">
        <label for="lastname">Lastname:</label>
        <input type="text" id="lastname" name="lastname"placeholder="Lastname">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password"placeholder="Password">
        <label for="rptPassword">Repeat Password:</label>
        <input type="password" id="rptPassword" name="rptPassword"placeholder="Repeat password">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email"placeholder="Email"><br>
        <button type="submit" name="submit">Register</button>
    </form>
    <p>Already have an account? <a href="login.php">Log in instead</a></p>
</div>
<?php
    include_once "footer.php";
    ?>
</body>
</html>
