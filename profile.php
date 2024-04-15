<?php
$title = "Profile page";
$css_file = "./css-files/header.css";
$css_filee = "./css-files/profileStyle.css";
include_once "header.php";
include_once "profileModel.php";
include_once "profileController.php";
include_once "profileView.php";
include_once "deviceModel.php";
include_once "deviceController.php";
include_once "deviceView.php";
require_once "validateSession.php";
?>
<body>
    <main>
<?php if(isset($_GET["username"])) {
    $username = $_GET["username"];
    $profileInfo = new ProfileView();
    $profileInfo = $profileInfo->fetchPublicProfileInfo($username);
    $controller = new DeviceController();
    $deviceInfo = new DeviceView($controller);
    $items = $deviceInfo->fetchPublicDeviceInfo($profileInfo["user_id"]);
    
    ?>
    <div class = "container-info">
        <h1>Nickname: <?= $profileInfo["user_nickname"]?></h1>
        <?php if (!empty($profileInfo["user_image"])) { ?>
            <img class="avatar" src="<?= $profileInfo["user_image"]?>">
        <?php } ?>
        <?php if (!empty($profileInfo["user_description"])) {?>
            <p>Bio: <br> <?= $profileInfo["user_description"]?></p>
        <?php } ?>
        <p>Name: <?= $profileInfo["user_name"]?></p>
        <p>Email: <?= $profileInfo["user_email"]?></p>
    
    <section>
        <div class="service-boxes">
            
                <?php if(!empty($items)){?>
                    <div class="container">
                     <?php foreach($items as $row) {  ?>
                    <div class="col-lg-4">
                        <div class="service-box">
                            <div class="box-inner">
                                <img src="<?= $row["crypto_device_image_name"]?>">
                                <div class="box-content">
                                    <h3 class="title"><?php echo $row["crypto_device_name"]; ?></h3>
                                    <h3 class="title"><?php echo $row["crypto_device_id"]; ?></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
                <?php } ?>
               
        </div>
        </div>
    </section>

<?php } else { ?>
<?php
isNotLoggedIn();
$profileInfo = new ProfileView();
$controller = new DeviceController();
$deviceInfo = new DeviceView($controller);
$items = $deviceInfo->fetchAllDeivces($_SESSION["user_id"]);
?>
<div class = "container-info">
    <?php if(isset($_SESSION["profileMessage"])) { ?>
        <h5><?= $_SESSION['profileMessage'] ?></h5> <?php
        unset($_SESSION["profieMessage"]);
    } ?>
    <h1>Hello <?= $profileInfo->fetchNickname($_SESSION["user_id"])?></h1>
    <?php if(!empty($profileInfo->fetchImage($_SESSION["user_id"]))) { ?>
        <img class="avatar" src="<?= $profileInfo->fetchImage($_SESSION["user_id"])?>">
    <?php } else { ?>
        <p>You don't have a profile Image set</p>
        <a href="profileSetting.php"><button type = "edit">Add your Avatar</button></a>
    <?php } ?>
    <?php if(!empty($profileInfo->fetchBio($_SESSION["user_id"]))) { ?>
        <p type="bio">User Bio: <br> <?= $profileInfo->fetchBio($_SESSION["user_id"])?></p>
    <?php } else { ?>
        <p>You don't have a profile Bio set</p>
        <a href="profileSetting.php"><button type = "edit">Add your Bio</button></a>
    <?php } ?>
    <p>User name: <?php $profileInfo->fetchName($_SESSION["user_id"])?></p>
    <p>User email: <?= $profileInfo->fetchEmail($_SESSION["user_id"])?></p>
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
                                    <a href="deviceEdit.php?deviceId=<?php echo $row["crypto_device_id"]; ?>&userId=<?php echo $_SESSION["user_id"]; ?>" class="link-device-edit" ><button type ="edit">Edit Device</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
    
    <?php } ?>
    </main>
    <?php
    include_once "footer.php";
    ?>

</body>
</html>
