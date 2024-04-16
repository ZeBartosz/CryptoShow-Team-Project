<?php

include_once "deviceModel.php";
/**
 * Class DeviceView
 * Handles the view logic for device-related information
 */
class DeviceView extends DeviceModel {

    private $controller;

    /**
     * Constructor
     * Initialises a new instance of the DeviceView class.
     *
     * @param DeviceController $controller The controller instance
     */
    public function __construct($controller){
        $this->controller = $controller;
    }

    /**
     * Fetches the device name that are connected to the userId
     *
     * @param int $userId The ID of the user
     */
    public function fetchDeviceName($userId){
        $profileInfo = $this->getDevicesInfo($userId);
        //echos the result in the first row
        echo $profileInfo[0]["crypto_device_name"];
    }

    /**
     * Fetches the device image file location that are connected to the userId
     *
     * @param int $userId The ID of the user
     */
    public function fetchDeviceImagine($userId){
        $profileInfo = $this->getDevicesInfo($userId);
        //echos the result in the first row
        echo $profileInfo[0]["crypto_device_image_name"];
    }

    /**
     * Fetches the visibility status of a device that are connected to the userId
     *
     * @param int $userId The ID of the user
     */
    public function fetchDeviceVisible($userId){
        $profileInfo = $this->getDevicesInfo($userId);
        //echos the result in the first row
        echo $profileInfo[0]["crypto_device_record_visible"];
    }

    /**
     * Fetches all devices that are connected to the userId
     *
     * @param int $userId The ID of the user
     * @return array An array containing information about all devices
     */
    public function fetchAllDeivces($userId){
        $profileInfo = $this->getDevicesInfo($userId);

        return $profileInfo;
    }

    /**
     * Fetches devices information where visibility is set to 1 and that are connected to the userId
     *
     * @param int $userId The ID of the user
     * @return array An array containing public device information
     */
    public function fetchPublicDeviceInfo($userId){
        return $this->getPublicDeviceInfo($userId);
    }

    /**
     * Fetches the name of a specific device
     *
     * @param int $deviceId The ID of the device
     */
    public function fetchSpeDeviceName($deviceId){
        $profileInfo = $this->getSpecificDevicesInfo($deviceId);
        //echos the result in the first row
        echo $profileInfo[0]["crypto_device_name"];
    }

    /**
     * Fetches the image name of a specific device
     *
     * @param int $deviceId The ID of the device
     * @return string The image file location of the device
     */
    public function fetchSpeDeviceImagine($deviceId){
        $profileInfo = $this->getSpecificDevicesInfo($deviceId);

        return $profileInfo[0]["crypto_device_image_name"];
    }

    /**
     * Fetches the visibility status of a specific device
     *
     * @param int $deviceId The ID of the device
     * @return int The visibility status of the device
     */
    public function fetchSpeDeviceVisible($deviceId){
        $profileInfo = $this->getSpecificDevicesInfo($deviceId);

        return $profileInfo[0]["crypto_device_record_visible"];
    }

     /**
     * Displays all device information or searched device information based on a search keyword.
     *
     * This method outputs HTML directly to display a table of devices. If a "search_device" POST parameter
     * is set, it filters the device list by the specified keyword. Otherwise, it displays all devices.
     * The table includes options to edit or delete each device, with confirmation for deletions.
     */
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
