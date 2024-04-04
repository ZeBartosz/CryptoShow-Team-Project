<?php
    $title = "Add Device";
    $css_file = "./css-files/dashboardStyle.css";
    include_once "header.php";
    include "deviceProcess.php";
    include "deviceController.php";
    include "deviceView.php";

?>


    <section class="profile">
        <div class="profile-bg">
            <div class="wrapper">
                <div class="profile-settings">
                    <h3>ADD DEVICE</h3>
                    <form action="./php-files/deviceAddProcess.php" method="post">
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
