<?php
$title = "Admin Page";
$css_file = "./css-files/dashboardStyle.css";
include_once "header.php";
require_once "validateAdmin.php";
include "db_connect.php";
include_once "userView.php";
include_once "userModel.php";
include_once "eventView.php";
include_once "eventController.php";
include_once "deviceController.php";
include_once "deviceView.php";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST["delete_user"])) {
        $user_id = $_POST["delete_user"];
        $model = new UserModel();
        $model->deleteUserInfo($user_id);
        header("Location: {$_SERVER['PHP_SELF']}");
        exit();
    }
    if(isset($_POST["delete_event"])) {
        $event_id = $_POST["delete_event"];
        $model = new EventModel();
        $model->deleteEvent($event_id);
        header("Location: {$_SERVER['PHP_SELF']}");
        exit();
    }
    if(isset($_POST["publish"])) {
        $event_id = $_POST["publish"];
        $model = new EventModel();
        $model->publishEvent($event_id);
        header("Location: {$_SERVER['PHP_SELF']}");
        exit();
    }
    if(isset($_POST["delete_device"])) {
        $device_id = $_POST["delete_device"];
        $model = new DeviceModel();
        $model->deleteDeviceInfo($device_id);
        header("Location: {$_SERVER['PHP_SELF']}");
        exit();
    }

}


?>
<link rel="stylesheet" href="./css-files/adminStyle.css">
<?php if(isset($_SESSION["message"])) { ?>
    <h5><?= $_SESSION['message'] ?></h5> <?php
    unset($_SESSION["message"]);
} ?>
<div class="container">
    <div class="tabs">
        <button class="tabBtn active">Users</button>
        <button class="tabBtn">Events</button>
        <button class="tabBtn">Devices</button>
        <div class="line"></div>
    </div>
    <div class="contentBox">
        <div class="content active">
            <h2>Users</h2>
            <table>
                <thead>
                <tr>
                    <th>Admin</th>
                    <th>User ID</th>
                    <th>Nickname</th>
                    <th>Fullname</th>
                    <th>Email</th>
                    <th>Device count</th>
                    <th>Registered</th>
                    <th>Edit</th>
                </tr>
                </thead>
                <tbody>
                <?php
                    $userController = new UserController();
                    $userView = new UserView($userController);
                    $userDisplayed = $userView->displayAllUserInfo();
                if(!$userDisplayed === true) {
                    echo "<tr>";
                    echo "<td colspan='7'>No Record</td>";
                    echo "</tr>";
                }
                ?>

                </tbody>
            </table>
        </div>
        <div class="content">
            <h2>Events</h2>
            <div>
                <a href="./addEvent.php"><button>Add Event</button></a>
            </div>
            <table>
                <thead>
                <tr>
                    <th>Event ID</th>
                    <th>Event Name</th>
                    <th>Event Description</th>
                    <th>Event Date</th>
                    <th>Event Venue</th>
                    <th>Published</th>
                    <th>Edit</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $eventController = new EventController();
                $userView = new EventView($eventController);
                $eventDisplayed = $userView->displayAllEvents();
                if(!$eventDisplayed === true) {
                    echo "<tr>";
                    echo "<td colspan='6'>No Record</td>";
                    echo "</tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
        <div class="content">
            <h2>Devices</h2>
            <table>
                <thead>
                <tr>
                    <th>Device Visible</th>
                    <th>Device ID</th>
                    <th>Device Name</th>
                    <th>User ID</th>
                    <th>Device Registered</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $deviceController = new DeviceController();
                $deviceView = new DeviceView($deviceController);
                $deviceDisplayed = $deviceView->displayAllDeviceInfo();
                if(!$eventDisplayed === true) {
                    echo "<tr>";
                    echo "<td colspan='6'>No Record</td>";
                    echo "</tr>";
                }
                ?>
                </tbody>
            </table>
        </div>

    </div>
</div>

<div>

</div>


<footer>
    <p>&copy; 2024 CryptoShow. All rights reserved.</p>
</footer>

</body>

</html>