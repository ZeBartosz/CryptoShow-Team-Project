<?php
$title = "Welcome to Cryptoshow";
$css_file = "./css-files/dashboardStyle.css";
include_once "header.php";
?>
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



    <footer>
        <p>&copy; 2024 CryptoShow. All rights reserved.</p>
    </footer>

</body>

</html>
