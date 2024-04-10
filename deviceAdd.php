<?php
    $title = "Add Device";
    $css_file = "./css-files/dashboardStyle.css";
    include_once "header.php";
    include "deviceProcess.php";
    include "deviceController.php";
    include "deviceView.php";
    $fileDestination = '';


    if(isset($_POST["submit"])) {

        $id = $_SESSION["user_id"];

        $name = htmlspecialchars($_POST["name"], ENT_QUOTES, "UTF-8");
        $isVisible = isset($_POST["visible"])? 1 : 0;

        $id = $_SESSION["user_id"];
        $file = $_FILES['file'];

        $fileName = $file['name'];
        $fileTmpName = $file['tmp_name'];
        $fileSize = $file['size'];
        $fileError = $file['error'];
        $fileType = $file['type'];

        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));
        $allowed = array('jpg', 'jpeg'. 'png');
        $fileDestination = '';

        if(in_array($fileActualExt, $allowed)){
            if ($fileError === 0){
                if ($fileSize < 3000000){
                    $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
                    $randomString = substr(str_shuffle($str_result), 0, 5);
                    $fileNameNew = "profile".$id.$randomString.".".$fileActualExt;
                    $fileDestination = 'device-images/'.$fileNameNew;
                    move_uploaded_file($fileTmpName, $fileDestination);
                } else {
                    header("Location: profile.php?error=imageTooBig");
                    exit();
                }

            } else {
                header("Location: profile.php?error=ErrorImage");
                exit();
            }
        } else {
            header("Location: profile.php?error=wrong");
            exit();
        }


        $deviceInfo = new DeviceController($id);

        $deviceInfo->insertDevice($name, $fileDestination, $isVisible);


    }

?>


    <section class="profile">
        <div class="profile-bg">
            <div class="wrapper">
                <div class="profile-settings">
                    <h3>ADD DEVICE</h3>
                    <form method="post">
                        <P>Device name!</P>
                        <input type="text" name="name" placeholder="device name...">
                        <p>Device image!</p>
                        <input type="file" name="file" value="" >
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
