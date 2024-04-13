<?php
    ini_set("file_upload", "On");
    $title = "Add Device";
    $css_file = "./css-files/dashboardStyle.css";
    include_once "header.php";
    include "deviceModel.php";
    include "deviceController.php";
    include "deviceView.php";
    include "profileModel.php";
    include "profileController.php";
    include "profileView.php";

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = $_SESSION["user_id"];
        $name = htmlspecialchars($_POST["name"], ENT_QUOTES, "UTF-8");
        $is_visible = isset($_POST["visible"])? 1 : 0;

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

        if ($_FILES["image"]["size"] > 300000000 ){
            header("location: {$_SERVER['PHP_SELF']}");
            $_SESSION["message"] = "Error image too large ";
            exit();
        }

        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

        $deviceInfo = new DeviceController();

        $deviceInfo->setForeignId($id);
        $deviceInfo->insertDevice($name, $target_file, $is_visible);

        $profileView = new ProfileView();
        $deviceCount = $profileView->fetchDeivceCount($id) + 1;

        $profileView = new ProfileController($id);
        $profileView->updateDeviceCount($deviceCount);


        header("location: profile.php?error=no");



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
                    <h3>ADD DEVICE</h3>
                    <form method="post" enctype="multipart/form-data">
                        <label for="name">Device Name:</label>
                        <input type="text" name="name" placeholder="device name...">
                        <label for="image">Device Image:</label>
                        <input type="file" name="image" placeholder="device image..." >
                        <label for="visible">Device Visibility:</label>
                        <input type="checkbox" name="visible" value="checked" >
                        <button type="submit" name="submit">ADD</button>
                    </form>
                </div>
            </div>
        </div>
    </section>


</body>
</html>
