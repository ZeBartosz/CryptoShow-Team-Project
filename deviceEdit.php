<?php
$title = "Edit Device";
$css_file = "./css-files/adminStyle.css";
$css_filee = "./css-files/header.css";

include_once "header.php";
include "deviceModel.php";
include "deviceController.php";
include "deviceView.php";
if(isset($_SESSION["user_id"]) == $_GET["userId"] || $_SESSION["is_admin"]) {
} else {
    header("location: index.php?error=none");
}

$deviceController = new DeviceController();
$deviceInfo1 = new DeviceView($deviceController);
$deviceId = $_GET["deviceId"];

if(isset($_POST["submit"])) {
    if (isset($deviceId)) {
        $id = $_SESSION["user_id"];

        $name = htmlspecialchars($_POST["name"], ENT_QUOTES, "UTF-8");
        $is_visible = isset($_POST["visible"])? 1 : 0;
        $deviceInfo = new DeviceController();

        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

        $deviceInfo->setForeignId($id);
        $deviceInfo->updateDeivce($name, $target_file, $is_visible, $deviceId);

        if(isset($_GET["isAdmin"]) == 1) {
            $_SESSION["message"] = "Edited device successfully";
            header("location: admin.php");
            exit();
        }
        header("location: profile.php?error=none");
    }
}

if(isset($_POST["delete"])) {
    if (isset($deviceId)) {
        $id = $_SESSION["user_id"];

        $deviceInfo = new DeviceController();
        $deviceInfo->setForeignId($id);


        $deviceInfo->deleteDevice($deviceId);
        if(isset($_GET["isAdmin"]) == 1) {
            $_SESSION["message"] = "Device deleted successfully";
            header("location: admin.php");
            exit();
        }
        
        header("location: profile.php?error=none");
    }


}
?>
<section class="profile">
    <div class="profile-bg">
        <div class="wrapper">
            <div class="profile-settings">
                <h3>DEVICE SETTINGS</h3>
                <form class="edit-form" method="post" enctype="multipart/form-data">
                    <P>Change Device name! <?php echo $deviceId; ?></P>
                    <input type="text" name="name" placeholder="Device name..." value="<?php $deviceInfo1->fetchSpeDeviceName($deviceId)?>">
                    <p>Change your device image!</p>
                    <input type="file" name="image" placeholder="device image..." >
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
