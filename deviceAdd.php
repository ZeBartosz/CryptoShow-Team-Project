<?php
    $title = "Add Device";
    $css_file = "./css-files/header.css";
    $css_filee = "./css-files/adminStyle.css";
    include_once "header.php";
    include "deviceModel.php";
    include "deviceController.php";
    include "deviceView.php";

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = $_SESSION["user_id"];
        $name = htmlspecialchars($_POST["name"], ENT_QUOTES, "UTF-8");
        $is_visible = isset($_POST["visible"])? 1 : 0;

        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);


        $deviceInfo = new DeviceController();

        $deviceInfo->setForeignId($id);
        $deviceInfo->insertDevice($name, $target_file, $is_visible);


    }
?>


    <section class="profile">
        <div class="profile-bg">
            <div class="wrapper">
                <div class="profile-settings">
                    <h3>ADD DEVICE</h3>
                    <form class="edit-form" method="post" enctype="multipart/form-data">
                        <P>Change your device name!</P>
                        <input type="text" name="name" placeholder="device name...">
                        <p>Change your device image!</p>
                        <input type="file" name="image" placeholder="device image..." >
                        <p>Change your device shown!</p>
                        <input type="checkbox" name="visible" value="checked" >
                        <button type="submit" name="submit">ADD</button>
                    </form>
                </div>
            </div>
        </div>
    </section>


</body>
</html>
