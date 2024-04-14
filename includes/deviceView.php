<?php

include_once "deviceModel.php";
class DeviceView extends DeviceModel {

    private $controller;

    public function __construct($controller) {
        $this->controller = $controller;
    }


    public function fetchDeviceName($userId){
        $profileInfo = $this->getDevicesInfo($userId);

        echo $profileInfo[0]["crypto_device_name"];
    }

    public function fetchDeviceImagine($userId){
        $profileInfo = $this->getDevicesInfo($userId);

        echo $profileInfo[0]["crypto_device_image_name"];
    }


    public function fetchDeviceVisible($userId){
        $profileInfo = $this->getDevicesInfo($userId);

        echo $profileInfo[0]["crypto_device_record_visible"];
    }

    public function fetchAllDeivces($userId){
        $profileInfo = $this->getDevicesInfo($userId);

        return $profileInfo;
    }

    public function fetchPublicDeviceInfo($userId) {
        return $this->getPublicDeviceInfo($userId);
    }

    public function fetchSpeDeviceName($deviceId){
        $profileInfo = $this->getSpecificDevicesInfo($deviceId);

        echo $profileInfo[0]["crypto_device_name"];
    }

    public function fetchSpeDeviceImagine($deviceId){
        $profileInfo = $this->getSpecificDevicesInfo($deviceId);

        return $profileInfo[0]["crypto_device_image"];
    }


    public function fetchSpeDeviceVisible($deviceId){
        $profileInfo = $this->getSpecificDevicesInfo($deviceId);

        return $profileInfo[0]["crypto_device_record_visible"];
    }


    public function displayAllDeviceInfo() {
        if (isset($_POST["search_device"])) {
            $search_keyword = $_POST["search_device"];
            $device_info = $this->controller->searchDeviceByKeyword($search_keyword);
        } else {
            $device_info = $this->controller->getAllDeviceInfo();
        }
        echo '<div class="content active">
            <h2>Devices</h2>
            <table>
                <thead>
                    <tr>
                        <th>Device Visible</th>
                        <th>Device ID</th>
                        <th>Device Name</th>
                        <th>User ID</th>
                        <th>Device Registered</th>
                        <th colspan ="2">Edit</th>
                    </tr>
                </thead>
                <tbody>';
        if (!empty($device_info)) {
            foreach ($device_info as $event) {
                echo "<tr>";
                echo "<td>" . ($event['crypto_device_record_visible'] ? "Yes" : "No") . "</td>";
                echo "<td>" . ($event['crypto_device_id']) . "</td>";
                echo "<td>" . $event["crypto_device_name"] . "</td>";
                echo "<td>" . $event['fk_user_id'] . "</td>";
                echo "<td>" . ($event['crypto_device_registered_timestamp']) . "</td>";
                echo '<td><a href="deviceEdit.php?deviceId=' . $event["crypto_device_id"] . '&userId=' . $_SESSION["user_id"] . '&isAdmin=' . $_SESSION["is_admin"] . '"><button type ="submit">Edit</button></a>';
                echo '
                        <form method="post">
                            <input type="hidden" name="delete_device" value="' . $event['crypto_device_id'] . '">
                            <button type="delete" onclick="return confirm(\'Are you sure?\')">Delete</button>
                        </form>
                    </td>';
                echo "</tr>";
            }
        } else {
            echo "<tr>";
            echo "<td colspan='5'>No Record</td>";
            echo "</tr>";
        }
        echo '    </tbody> </table> </div>';
    }
}
