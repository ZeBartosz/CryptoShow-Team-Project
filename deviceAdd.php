<?php
    ini_set("file_upload", "On");
    $title = "Add Device";
    $css_file = "./css-files/adminStyle.css";
    $css_filee = "./css-files/header.css";
    include_once "header.php";
    include "deviceModel.php";
    include "deviceController.php";
    include "deviceView.php";
    include "profileModel.php";
    include "profileController.php";
    include "profileView.php";
    include_once "validateSession.php";
    isNotLoggedIn();

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

        if ($_FILES["image"]["size"] > 200000000 ){
            header("location: {$_SERVER['PHP_SELF']}");
            $_SESSION["message"] = "Error image too large ";
            exit();
        }

        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $count = "1";
        while (file_exists($target_file)) {
            $target_file = $target_dir . $count . basename($_FILES["image"]["name"]);
            $count++;
        }

        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

        $deviceInfo = new DeviceController();

        $profileView = new ProfileView();
        $deviceCount = $profileView->fetchDeivceCount($id);

        if ($deviceCount < 5){
            $deviceInfo->setForeignId($id);
            $deviceInfo->insertDevice($name, $target_file, $is_visible);

            $deviceCount++;

            $profileView = new ProfileController($id);
            $profileView->updateDeviceCount($deviceCount);
        } else {
            header("location: profile.php?error=deviceCountReached");
            $_SESSION["profileMessage"] = "Error device count reached";
            exit();
        }


        $_SESSION["profileMessage"] = "added device successfully";
        header("location: profile.php");



   }
?>


<main>
    <section class="profile">
        <?php if(isset($_SESSION["message"])) { ?>
            <h5><?= $_SESSION['message'] ?></h5> <?php
            unset($_SESSION["message"]);
        } ?>
        <div class="profile-bg">
            <div class="wrapper">
                <div class="profile-settings">
                    
                    <form class="edit-form" method="post" enctype="multipart/form-data">
                        <?php if(isset($_SESSION["message"])) { ?>
                            <h5><?= $_SESSION['message'] ?></h5> <?php
                            unset($_SESSION["message"]);
                        } ?>
                        <h3>ADD DEVICE</h3>
                        <label for="name">Device Name:</label>
                        <input type="text" name="name" placeholder="device name..." required>
                        <label for="image">Device Image: max 2Mb</label>
                        <input type="file" name="image" placeholder="device image..." required>
                        <label for="visible">Device Visibility:</label>
                        <input type="checkbox" name="visible" value="checked">
                        <button type="submit" name="submit">ADD</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    </main>
    <?php
    include_once "footer.php";
    ?>


</body>
</html>
