<?php
$title = "Welcome to Cryptoshow";
$css_file = "./css-files/IndexStyle.css";
$css_filee = "./css-files/header.css";

include_once "header.php";
?>

<main>
<div class="container">
        <div class="carousel-container">
            <div class="carousel">
                <div class="event-image"><img src="./images/event1.jpg" alt="Slide 1"></div>
                <div class="event-image"><img src="./images/cryptodeviceindex.jpg" alt="Slide 2"></div>
                <div class="event-image"><img src="./images/cryptodeviceindex3.jpg" alt="Slide 3"></div>
            </div>
            <div class="carousel-arrows">
                <button class="arrow-btn prev" onclick="prevImage()"></button>
                <button class="arrow-btn next" onclick="nextImage()"></button>
            </div>
        </div>
    </div>
    <div class="website-features">
        <form action="./eventList.php">
        <button class="features" href="./eventList.php">
            <h2>View events</h2>
            <p>View all the latest events</p>
        </button>
        </form>
        <form action="./learnMore.php">
        <button class="features">
            <h2>Learn More</h2>
            <p>Learn more about cryptographic devices</p>
        </button>
        </form>
    </div>
</main>


    <?php
    include_once "footer.php";
    ?>
</body>

</html>
