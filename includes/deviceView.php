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

    public function fetchSpeDeviceName($deviceId){
        $profileInfo = $this->getSpecificDevicesInfo($deviceId);

        echo $profileInfo[0]["crypto_device_name"];
    }

    public function fetchSpeDeviceImagine($deviceId){
        $profileInfo = $this->getSpecificDevicesInfo($deviceId);

        echo $profileInfo[0]["crypto_device_image"];
    }


    public function fetchSpeDeviceVisible($deviceId){
        $profileInfo = $this->getSpecificDevicesInfo($deviceId);

        return $profileInfo[0]["crypto_device_record_visible"];
    }

    public function displayAllDeviceInfo() {
        $device_info = $this->controller->getAllDeviceInfo();

        if($device_info) {
            foreach($device_info as $event) {
                echo "<tr>";
                echo "<td>" . ($event['crypto_device_record_visible'] ? "Yes" : "No") . "</td>";
                echo "<td>" . ($event['crypto_device_id']) . "</td>";
                echo "<td>" . $event["crypto_device_name"] . "</td>";
                echo "<td>" . $event['fk_user_id'] . "</td>";
                echo "<td>" . ($event['crypto_device_registered_timestamp']) . "</td>";
                echo '<td><a href="deviceEdit.php?deviceId=' . $event["crypto_device_id"] . '&userId=' . $_SESSION["user_id"] . '&isAdmin=' . $_SESSION["is_admin"] . '"><button>Edit</button></a></td>';
                echo '<td>
                        <form method="post">
                            <input type="hidden" name="delete_device" value="' . $event['crypto_device_id'] . '">
                            <button type="submit" onclick="return confirm(\'Are you sure?\')">Delete</button>
                        </form>
                    </td>';
                echo "</tr>";
            }
            return true;
        }
    }

}
