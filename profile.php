<?php
$title = "Profile page";
$css_file = "./css-files/header.css";
$css_filee = "./css-files/profileStyle.css";
include_once "header.php";
include "profileinfo.php";
include "profileinfo_contrl.php";
include "profileinfo_view.php";
include "deviceModel.php";
include "deviceController.php";
include "deviceView.php";
require_once "validateSession.php";
$profileInfo = new ProfileInfoView();
$controller = new DeviceController();
$deviceInfo = new DeviceView($controller);

$items = $deviceInfo->fetchAllDeivces($_SESSION["user_id"]);

?>
<body>
    <div class = "container-info">
        <h1>User nickname: <?php $profileInfo->fetchNickname($_SESSION["user_id"])?></h1>
        <p>User name: <?php $profileInfo->fetchName($_SESSION["user_id"])?></p>
        <p>User email: <?php $profileInfo->fetchEmail($_SESSION["user_id"])?></p>
        <a href="profileSetting.php"><button type = "edit">Edit Profile</button></a>
        <a href="deviceAdd.php"><button type ="edit">Add Device</button></a>
    

    <section>
        <p>User device count: <?php echo $profileInfo->fetchDeivceCount($_SESSION["user_id"]); ?>/5</p>
        <div class="service-boxes">
            <div class="container">
                <?php foreach($items as $row) { ?>
                <div class="col-lg-4">
                    <div class="service-box">
                        <div class="box-inner">
                            <img src="<?= $row["crypto_device_image_name"]?>">
                            <div class="box-content">
                                <h3 class="title"><?php echo $row["crypto_device_name"]; ?></h3>
                                <h3 class="title"><?php echo $row["crypto_device_id"]; ?></h3>
                                <a href="deviceEdit.php?deviceId=<?php echo $row["crypto_device_id"]; ?>&userId=<?php echo $_SESSION["user_id"]; ?>" class="link-device-edit" >Edit Device</a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>

        
    </section>
</body>

</body>
</html>
