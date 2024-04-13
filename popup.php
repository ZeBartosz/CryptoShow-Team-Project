<?php
$title = " event details";
$css_file = "./css-files/dashboardStyle.css";
$css_filee = "./css-files/popup.css";
include_once "header.php";
include_once "userView.php";
include_once "userController.php";



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION["event_date"] = $_POST["event_date"];
    $_SESSION["event_name"] = $_POST["event_name"];
    $_SESSION["event_venue"] = $_POST["event_venue"];
    $_SESSION["event_description"] = $_POST["event_description"];
    $_SESSION["event_id"] = $_POST["event_id"];
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
            <p><?php echo $_SESSION["event_description"]?></p>
        </section>
        <section class="event-devices">
            <?php
            $event_id = $_SESSION["event_id"];
            $userView = new UserView(new UserController());
            $userView->displayAttendingUsers($event_id);
            ?>
        </section>
    </div>

</body>
</html>


