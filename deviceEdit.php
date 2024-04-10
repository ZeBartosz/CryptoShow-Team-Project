<?php
$title = "Edit Device";
$css_file = "./css-files/dashboardStyle.css";
include_once "header.php";
include "deviceProcess.php";
include "deviceController.php";
include "deviceView.php";

if($_SESSION["user_id"] == $_GET["userId"] || $_SESSION["is_admin"]) {
} else {
    header("location: index.php?error=none");
}

$deviceInfo1 = new DeviceView();
$deviceId = $_GET["deviceId"];

if(isset($_POST["submit"])) {
    if (isset($deviceId)) {
        $id = $_SESSION["user_id"];

        $name = htmlspecialchars($_POST["name"], ENT_QUOTES, "UTF-8");
        $picture = htmlspecialchars($_POST["picture"], ENT_QUOTES, "UTF-8");
        $is_visible = isset($_POST["visible"])? 1 : 0;

        $deviceInfo = new DeviceController($id);

        $deviceInfo->updateDeivce($name, $picture, $is_visible, $deviceId);

        header("location: profile.php?error=none");
    }
}

if(isset($_POST["delete"])) {
    if (isset($deviceId)) {
        $id = $_SESSION["user_id"];

        $deviceInfo = new DeviceController($id);

        $deviceInfo->deleteDevice($deviceId);

        header("location: profile.php?error=none");
    }


}
?>
<section class="profile">
    <div class="profile-bg">
        <div class="wrapper">
            <div class="profile-settings">
                <h3>DEVICE SETTINGS</h3>
                <form method="post">
                    <P>Change Device name!</P>
                    <input type="text" name="name" placeholder="Device name..." value="<?php $deviceInfo1->fetchSpeDeviceName($deviceId)?>">
                    <p>Change Device picture!</p>
                    <input type="text" name="picture" placeholder="Device picture..." value="<?php $deviceInfo1->fetchSpeDeviceImagine($deviceId)?>">
                    <p>Change visibility!</p>

                    <input type="checkbox" <?php if($deviceInfo1->fetchSpeDeviceVisible($deviceId)) echo "checked";?> value="<?php $deviceInfo1->fetchSpeDeviceVisible($deviceId) ?>" name="visible">
                    <button type="submit" name="submit">SAVE</button>
                    <form method="post">
                        <button type="submit" name="delete">Delete Device</button>
                    </form>
                </form>
            </div>
        </div>
    </div>
</section>


</body>
</html>
