<?php
$title = "Admin Page";
$css_file = "./css-files/adminStyle.css";
$css_filee = "./css-files/header.css";
include_once "header.php";
require_once "validateAdmin.php";
include "db_connect.php";
include_once "userView.php";
include_once "userModel.php";
include_once "eventView.php";
include_once "eventController.php";
include_once "deviceController.php";
include_once "deviceView.php";

if(!isset($_GET["tab"])) {
    header("location: admin.php?tab=users");
}
$current_tab = $_GET['tab'];

if($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST["delete_user"])) {
        $user_id = $_POST["delete_user"];
        $controller = new UserController();
        $controller->deleteUserInfo($user_id);
        header("Location: {$_SERVER['PHP_SELF']}");
        exit();
    }
    if(isset($_POST["delete_event"])) {
        $event_id = $_POST["delete_event"];
        $controller = new EventController();
        $controller->deleteEvent($event_id);
        header("Location: {$_SERVER['PHP_SELF']}");
        exit();
    }
    if(isset($_POST["publish"])) {
        $event_id = $_POST["publish"];
        $controller = new EventController();
        $controller->publishEvent($event_id);
        header("Location: {$_SERVER['PHP_SELF']}");
        exit();
    }
    if(isset($_POST["delete_device"])) {
        $device_id = $_POST["delete_device"];
        $controller = new DeviceController();
        $controller->getSpecificDevice($device_id);
        $profileView = new ProfileView();
        var_dump($controller);
        $controller->setForeignId($controller[0]["user_device_count"]);
        $deviceCount = $profileView->fetchDeivceCount($controller[0]["user_device_count"]) - 1;
        
        $profileView = new ProfileController($controller[0]["user_device_count"]);
        $profileView->updateDeviceCount($deviceCount); 
        $controller->deleteDeviceInfo($device_id);
        header("Location: {$_SERVER['PHP_SELF']}");
        exit();
    }
}

?>
<main>

<div class="container">
    <div class="tabs">
        <a href="?tab=users"><button class="tabBtn <?php echo ($_GET['tab'] == 'users' ? 'active' : ''); ?>">Users</button></a>
        <a href="?tab=events"><button class="tabBtn <?php echo ($_GET['tab'] == 'events' ? 'active' : ''); ?>">Events</button></a>
        <a href="?tab=devices"><button class="tabBtn <?php echo ($_GET['tab'] == 'devices' ? 'active' : ''); ?>">Devices</button></a>
    </div>
    <div class="contentBox">
        <?php if(isset($_SESSION["message"])) { ?>
            <h5><?= $_SESSION['message'] ?></h5> <?php
            unset($_SESSION["message"]);
        } ?>
    <div class="search">
             <form method="post">
                <label type="searchBox">Search:</label>
                <div class="glass">
                <input type="text" id="searchBox"
                       name="<?php if($current_tab === 'users'){
                    echo "search_user";
                }elseif ($current_tab === 'events') {
                    echo "search_event";
                } elseif ($current_tab === 'devices') {
                    echo "search_device";
                }  ?>" placeholder="Search...">
                <button type= "img"><img src ="./images/magnifying.png"></button>
                </div>
                <button type="submit" name="submit">Search</button>
                <button type="submit">Clear</button>
            </form>
        </div>
        <?php
        $userView = new UserView(new UserController());
        $eventView = new EventView(new EventController());
        $deviceView = new DeviceView(new DeviceController());
        if ($current_tab === 'users') {
            $userView->displayAllUserInfo();
        } elseif ($current_tab === 'events') {
            $eventView->displayAllEventInfo();
        } elseif ($current_tab === 'devices') {
            $deviceView->displayAllDeviceInfo();
        }
        ?>
    </div>
</div>
</main>
<?php
include_once "footer.php"
?>
</body>
</html>
