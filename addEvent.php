<?php
$title = "Add Event";
$css_file = "./css-files/dashboardStyle.css";
include "header.php";
require_once "validateAdmin.php";
include "db_connect.php";
?>

<form action="./php-files/eventAddProcess.php" method="post">
    <div>
        <label>Event name</label>
        <input type="text" name="name" placeholder="Event Name">
    </div>
    <div>
        <label>Event Description</label>
        <textarea name="desc" placeholder="Event Description"></textarea>
    </div>
    <div>
        <label>Event Date</label>
        <input type="date" name="date" placeholder="Event Date">
    </div>
    <div>
        <label>Event Venue</label>
        <input type="text" name="venue" placeholder="Event Venue">
    </div>
    <div>
        <label>Publish event</label>
        <input type="checkbox" name="publish" checked="">
    </div>
    <button type="submit" name="submit">Upload Event</button>
</form>

<footer>
    <p>&copy; 2024 CryptoShow. All rights reserved.</p>
</footer>

</body>

</html>