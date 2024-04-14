<?php
$css_file = "./css-files/header.css";
$css_filee = "./css-files/adminStyle.css";
include "header.php";
require_once "validateAdmin.php";
include "db_connect.php";
include_once "eventController.php";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $event_name = $_POST["name"];;
    $event_date = $_POST["date"];
    $event_description = $_POST["desc"];
    $event_venue = $_POST["venue"];
    $is_published = isset($_POST["publish"])? 1 : 0;
    $controller = new EventController();
    $result = $controller->addEvent($event_name, $event_description, $event_date, $event_venue, $is_published);

    if($result === true) {
        $_SESSION["message"] = "Successfully added event";
        header("location: ./admin.php?tab=events");

    } else {
        $_SESSION["message"] = "Error adding event";
        header("location: ./admin.php?tab=events");
        exit();
    }
}
?>
<?php if(isset($_SESSION["message"])) { ?>
    <h5><?= $_SESSION["message"] ?></h5> <?php
    unset($_SESSION["message"]);
} ?>
<form class="edit-form" method="post">
    <div>
        <label>Event name</label>
        <input type="text" name="name" placeholder="Event Name">
    </div>
    <div>
        <label>Event Description</label>
        <textarea name="desc" maxlength="255" placeholder="Event Description"></textarea>
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
<div class= "cancel-button">
<a href="./admin.php?tab=events"><button type= "user-cancel">Cancel</button></a>
</div>
<?php
include_once "footer.php";
?>
</body>
</html>
