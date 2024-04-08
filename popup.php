<?php
$title = " event details";
$css_file = "./css-files/dashboardStyle.css";
$css_file2 = "./css-files/popup.css";
include_once "./phpappfolder/includes/header.php";




if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION["event_date"] = $_POST["event_date"];
    $_SESSION["event_name"] = $_POST["event_name"];
    $_SESSION["event_venue"] = $_POST["event_venue"];

    // Redirect or perform other actions as needed
}
?>

        <div class="container">
        <h1 class="title_of_the_page"><?php echo  $_SESSION["event_name"]?></h1>
        <section class="event-info">
            <p><strong>Location:</strong> <?php echo  $_SESSION["event_venue"] ?></p>
            <p><strong>Date:</strong> <?php echo $_SESSION["event_date"]?></p>
        </section>
        <section class="event-description">
            <h2>Description of the Event</h2>
            <p>As the sun dipped below the horizon, the sky transformed into a breathtaking canvas of orange, pink, and purple hues. The gentle breeze carried the sweet scent of jasmine, adding to the serene ambiance. In the distance, the faint sound of a guitar strumming a melodious tune could be heard, blending harmoniously with the surroundings.</p>
        </section>
        <section class="event-devices">
            <h2>Devices which will be in this event:</h2>
            <table>
                <tr>
                    <th>owner of the device</th>
                    <th>The device he is bringing</th>
                </tr>
                <tr>
                    <td>youcef ab</td>
                    <td>router</td>
                </tr>
                <!-- Additional rows can be added here -->
            </table>
        </section>
    </div>
    <footer>
        <p>&copy; 2024 CryptoShow. All rights reserved.</p>
    </footer>
</body>
</html>
