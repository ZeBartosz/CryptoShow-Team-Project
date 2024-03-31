<?php
session_start();

if (isset($_SESSION['user_id'])) {
} else {
    header("Location: ../login.html");
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
    <script src="../Js-Files/carousel.js" defer></script>
</head>
<body>
    <header>
        <h1>CryptoShow</h1>
        <ul>
            <li><a href="./profile.php">Profile</a></li>
        </ul>
        <form action="logout.php" method="post">
            <button class="logoutBtn" type="submit">Logout</button>
        </form>
    </header>
    <div class="container">
        <div class="carousel-container">
            <div class="carousel">
                <div class="event-image"><img src="https://fakeimg.pl/960x400?text=1" alt="Slide 1"></div>
                <div class="event-image"><img src="https://fakeimg.pl/960x400?text=2" alt="Slide 2"></div>
                <div class="event-image"><img src="https://fakeimg.pl/960x400?text=3" alt="Slide 3"></div>
            </div>
            <div class="carousel-arrows">
                <button class="arrow-btn prev" onclick="prevImage()"></button>
                <button class="arrow-btn next" onclick="nextImage()"></button>
            </div>
        </div>
    </div>
    <div class="website-features">
        <button class="features">
            <h2>Lorem ipsum</h2>
            <p>Lorem ipsum</p>
        <button class="features">
            <h2>Lorem ipsum</h2>
            <p>Lorem ipsum</p>
        <button class="features">
            <h2>Lorem ipsum</h2>
            <p>Lorem ipsum</p>
    </div>
    <footer>
        <a href="#">About Us |</a>
        <a href="#">Contact Us |</a>
        <a href="#">Learn More</a>
        <p>&copy; 2024 CryptoShow. All rights reserved.</p>
    </footer>
</body>
</html>
