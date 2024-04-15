<?php
$css_file = "./css-files/adminStyle.css";
$css_filee = "./css-files/header.css";
include_once "header.php";
require_once "validateAdmin.php";
include "db_connect.php";
include "eventController.php";
?>

<?php
$controller = new EventController();
if(isset($_GET["eventId"])) {
    $event_id = $_GET["eventId"];

    $event_info = $controller->getEvent($event_id);
    if(!$event_info) {
        $_SESSION["message"] = "Invalid event ID";
        header("location: ./admin.php?tab=events");
        exit();
    }
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $event_id = $_POST["id"];
    $event_name = $_POST["name"];
    $event_date = $_POST["date"];
    $event_venue = $_POST["venue"];
    $event_description = htmlspecialchars($_POST["description"], ENT_QUOTES, "UTF-8");
    $controller = new EventController();
    $result = $controller->setEventInfo($event_id, $event_name, $event_description, $event_date, $event_venue);

    if($result === true) {
        $_SESSION["message"] = "Successfully edited user information";
        header("location: ./admin.php?tab=events");
        exit();
    } else {
        header("location: ./admin.php?tab=events");
        $_SESSION["message"] = "Error updating user information";
    }
}

?>
<?php if(isset($_SESSION["message"])) { ?>
    <h5><?= $_SESSION["message"] ?></h5> <?php
    unset($_SESSION["message"]);
} ?>
<main>
<form class="edit-form" method="post">
    <input type="hidden" value="<?= $event_info["event_id"] ?>" name="id">
    <div>
        <label>Event name</label>
        <input type="text" value="<?= $event_info["event_name"] ?>" name="name">
    </div>
    <div>
        <label>Event Description</label>
        <textarea name="description" maxlength="255"><?= $event_info["event_description"] ?></textarea>
    </div>
    <div>
        <label>Event Date</label>
        <input type="date" value="<?= $event_info["event_date"] ?>" name="date">
    </div>
    <div>
        <label>Event Venue</label>
        <input type="text" value="<?= $event_info["event_venue"] ?>" name="venue">
    </div>
    <button type="submit" name="submit">Update User</button>
    <a href="./admin.php?tab=events"><button type ="delete">Cancel</button></a>
</form>
</main>

<?php
include_once "footer.php";
?>
</body>

</html>
