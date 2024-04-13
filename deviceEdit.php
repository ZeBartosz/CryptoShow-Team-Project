<?php
ini_set("file_upload", "On");
$title = "Edit Device";
$css_file = "./css-files/dashboardStyle.css";
include_once "header.php";
include "deviceModel.php";
include "deviceController.php";
include "deviceView.php";
include "profileModel.php";
include "profileController.php";
include "profileView.php";

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

        $fileName = $_FILES["image"]["name"];
        $fileExt = explode('.', $fileName);
        $actualFileExt = strtolower(end($fileExt));
        $allowed = array('jpg', 'jpeg', 'png');

        if (!in_array($actualFileExt, $allowed)){
            header("location: {$_SERVER['PHP_SELF']}");
            $_SESSION["message"] = "Error wrong image compression";
            exit();

        }

        if($_FILES["image"]["error"] == 1){
            header("location: {$_SERVER['PHP_SELF']}");
            $_SESSION["message"] = "Error with the image";
            exit();

        }

        if ($_FILES["image"]["size"] > 200000000 ){
            header("location: {$_SERVER['PHP_SELF']}");
            $_SESSION["message"] = "Error image too large ";
            exit();
        }

        $profileInfo = new ProfileView();


        $target_file = $deviceInfo1->fetchDeviceImagine();
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

        $deviceInfo->setForeignId($id);
        $deviceInfo->updateDeivce($name, $target_file, $is_visible, $deviceId);

        if(isset($_GET["isAdmin"]) == 1) {
            $_SESSION["message"] = "Edited device successfully";
            header("location: admin.php");
            exit();
        }
        header("location: profile.php");
    }
}

if(isset($_POST["delete"])) {
    if (isset($deviceId)) {
        $id = $_SESSION["user_id"];

        $deviceInfo = new DeviceController();
        $deviceInfo->setForeignId($id);


        $deviceInfo->deleteDevice($deviceId);

        $profileView = new ProfileView();
        $deviceCount = $profileView->fetchDeivceCount($id) - 1;

        $profileView = new ProfileController($id);
        $profileView->updateDeviceCount($deviceCount);

        header("location: profile.php");
    }


}
?>

<?php if(isset($_SESSION["message"])) { ?>
    <h5><?= $_SESSION['message'] ?></h5> <?php
    unset($_SESSION["message"]);
} ?>
<section class="profile">
    <div class="profile-bg">
        <div class="wrapper">
            <div class="profile-settings">
                <h3>DEVICE SETTINGS</h3>
                <form class="edit-form" method="post" enctype="multipart/form-data">
                    <label for="name">Change Name:</label>
                    <input type="text" name="name" placeholder="Device name..." value="<?php $deviceInfo1->fetchSpeDeviceName($deviceId)?>">
                    <label for="image">Change image:</label>
                    <input type="file" name="image" placeholder="device image..." >
                    <label for="visible">Change visibility:</label>
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
