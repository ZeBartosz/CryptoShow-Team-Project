<?php
$title = "Edit Device";
$css_file = "./css-files/dashboardStyle.css";
include_once "header.php";
include "deviceProcess.php";
include "deviceController.php";
include "deviceView.php";
$deviceInfo1 = new DeviceView();
$deviceId = $_GET["deviceId"];

if(isset($_POST["submit"])) {
    if (isset($deviceId)) {
        $id = $_SESSION["user_id"];

        $name = htmlspecialchars($_POST["name"], ENT_QUOTES, "UTF-8");
        $picture = htmlspecialchars($_POST["picture"], ENT_QUOTES, "UTF-8");
        $visible = htmlspecialchars($_POST["visible"], ENT_QUOTES, "UTF-8");

        $deviceInfo = new DeviceController($id);

        $deviceInfo->updateDeivce($name, $picture, $visible, $deviceId);

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
                <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="post">
                    <P>Change Device name! <?php echo $deviceId; ?></P>
                    <input type="text" name="name" placeholder="Device name..." value="<?php $deviceInfo1->fetchSpeDeviceName($deviceId)?>">
                    <p>Change Device picture!</p>
                    <input type="text" name="picture" placeholder="Device picture..." value="<?php $deviceInfo1->fetchSpeDeviceImagine($deviceId)?>">
                    <p>Change visibility!</p>
                    <input type="text" name="visible" placeholder="visibility..." value="<?php $deviceInfo1->fetchSpeDeviceVisible($deviceId)?>">
                    <button type="submit" name="submit">SAVE</button>
                    <form action="<?php $_SERVER["PHP_SELF"]; ?>">
                        <button type="submit" name="delete">Delete Device</button>
                    </form>
                </form>
            </div>
        </div>
    </div>
</section>


</body>
</html>