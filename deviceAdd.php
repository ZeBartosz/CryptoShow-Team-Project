<?php
    $title = "Add Device";
    $css_file = "./css-files/dashboardStyle.css";
    include_once "header.php";
    include "deviceProcess.php";
    include "deviceController.php";
    include "deviceView.php";

    if(isset($_POST["submit"])) {

        $id = $_SESSION["user_id"];

        $name = htmlspecialchars($_POST["name"], ENT_QUOTES, "UTF-8");
        $image = htmlspecialchars($_POST["image"], ENT_QUOTES, "UTF-8");
        $visible = htmlspecialchars($_POST["visible"], ENT_QUOTES, "UTF-8" );

        $deviceInfo = new DeviceController($id);

        $deviceInfo->insertDevice($name, $image, $visible);

        header("location: profile.php?error=none");
    }

?>


    <section class="profile">
        <div class="profile-bg">
            <div class="wrapper">
                <div class="profile-settings">
                    <h3>ADD DEVICE</h3>
                    <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="post">
                        <P>Change your device name!</P>
                        <input type="text" name="name" placeholder="device name...">
                        <p>Change your device image!</p>
                        <input type="text" name="image" placeholder="device image..." >
                        <p>Change your device shown!</p>
                        <input type="text" name="visible" placeholder="device visible...TRUE/FALSE" >
                        <button type="submit" name="submit">ADD</button>
                    </form>
                </div>
            </div>
        </div>
    </section>


</body>
</html>
