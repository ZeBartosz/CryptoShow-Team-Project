<?php
$title = "Edit Event";
$css_file = "./css-files/header.css";
$css_filee ="./css-files/adminStyle.css";
include_once "header.php";
require_once "validateAdmin.php";
include "db_connect.php";
?>

<?php
if(isset($_GET["eventid"])) {
    $event_id = $_GET["eventid"];

    $query = "SELECT * FROM event WHERE event_id=:event";

    $stmt = $pdo->prepare($query);
    $data = [
      ":event" => $event_id
    ];
    $stmt->execute($data);

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
<form class="edit-form" action="./php-files/eventEditProcess.php" method="post">
    <input type="hidden" value="<?= $result["event_id"] ?>" name="id">
    <div>
        <label>Event Name:</label>
        <input type="text" value="<?= $result["event_name"] ?>" name="name">
    </div>
    <div>
        <label>Event Date:</label>
        <input type="date" value="<?= $result["event_date"] ?>" name="date">
    </div>
    <div>
        <label>Event Venue:</label>
        <input type="text" value="<?= $result["event_venue"] ?>" name="venue">
    </div>
    <div>
        <label class="desc">Event Description:</label>
        <textarea type="text" value="<?= $result["event_description"] ?>" name="description"></textarea>
    </div>
    <button type="submit" name="submit">Update Event</button>
</form>

<footer>
        <p>&copy; 2024 CryptoShow. All rights reserved.</p>
    </footer>

</body>

</html>
