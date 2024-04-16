<?php

include_once "deviceModel.php";

/**
 * Class DeviceController extends the deviceModel class
 * Handles control logic for device-related operations
 */
class DeviceController extends DeviceModel {

    private $userId;
    private $model;

    /**
     * Constructor
     * Initialises a new instance of the DeviceController class
     */
    public function __construct() {
        $this->model = new DeviceModel();
    }

    /**
     * Sets the foreign ID, which is the user ID, for the class variable
     *
     * @param string $userId The ID of the user
     */
    public function setForeignId($userId) {
        $this->userId = $userId;
    }

    /**
     * Validates the parameters and updates a specific device
     *
     * @param string $device_name The name of the device
     * @param string $device_image_name The location of the device image
     * @param int $crypto_device_record_visible Visibility status of the device
     * @param int $deviceID The ID of the device
     */
    public function updateDeivce($device_name, $device_image_name, $crypto_device_record_visible, $deviceID) {

        //checks if $device_name is empty
        if ($this->emptyInputCheck($device_name)) {
            //moves back to profile.php and exits the function
            header("location: profile.php?error=emptyinput");
            exit();
        }

        //checks if $crypto_device_record_visible is either 1 or 0
        if(!$this->isVisible($crypto_device_record_visible)) {
            //moves back to deviceEdit.php, sets session message and exits the function
            $_SESSION["message"] = "Error: Invalid checkbox input";
            header("location: {$_SERVER['PHP_SELF']}");
            exit();
        }

        //check if $device_name is a valid string
        if(!$this->invalidName($device_name)) {
            //moves back to deviceEdit.php, sets session message and exits the function
            $_SESSION["message"] = "Error: Invalid device name";
            header("location: {$_SERVER['PHP_SELF']}");
            exit();
        }

        //executes the function with the parameters
        $this->setNewProfileInfo($device_name, $device_image_name, $crypto_device_record_visible, $deviceID);
    }

    /**
     * Validates the parameters and inserts a new device into the database
     *
     * @param string $device_name The name of the device
     * @param string $device_image_name The image name of the device
     * @param int $crypto_device_record_visible Visibility status of the device record
     */
    public function insertDevice($device_name, $device_image_name, $crypto_device_record_visible) {

        //checks if $device_name is empty
        if ($this->emptyInputCheck($device_name)) {
            header("location: profile.php?error=emptyinput");
            exit();
        }

        //checks if $crypto_device_record_visible is either 1 or 0
        $result = $this->isVisible($crypto_device_record_visible);
        if($result === false) {
            //moves back to deviceAdd.php, sets session message and exits the function
            $_SESSION["message"] = "Error: Invalid checkbox input";
            header("location: {$_SERVER['PHP_SELF']}");
            exit();
        }

        //check if $device_name is a valid string
        if(!$this->invalidName($device_name)) {
            //moves back to deviceAdd.php, sets session message and exits the function
            $_SESSION["message"] = "Error: Invalid device name";
            header("location: {$_SERVER['PHP_SELF']}");
            exit();
        }

        //executes the function with the parameters
        $this->setDevice($device_name, $device_image_name, $crypto_device_record_visible, $this->userId);
    }

    /**
     * Deletes a device from the database
     *
     * @param int $deviceId The ID of the device
     */
    public function deleteDevice($deviceId) {

        //checks if $deviceId is empty
        if (empty($deviceId)) {
            //if true, moves back to profile.php and exits the function
            header("location: profile.php?error=emptyinput");
            exit();
        } else {
            //if false, runs the function
            $this->deleteThisDevice($deviceId);
        }
    }

    /**
     * Deletes device from the database, used in admin.php
     *
     * @param int $device_id The ID of the device
     */
    public function deleteDeviceInfo($device_id) {
        //Runs the function
        $this->model->deleteDeviceInfo($device_id);
    }

    /**
     * Searches for devices in the database based on a keyword, used in admin.php
     *
     * @param string $search_keyword The keyword to search for
     * @return array An array containing information about devices matching the search keyword
     */
    public function searchDeviceByKeyword($search_keyword) {
        try {
            //runs the function
            return $this->model->fetchSearchDeviceByKeyword($search_keyword);
            //catches any errors
        } catch (PDOException $e) {
            $_SESSION["message"] = "Error searching device info: " . $e->getMessage();
            header("Location: admin.php?tab=devices");
            exit();
        }
    }

    /**
     * Checks if the input is empty
     *
     * @param string $device_name The device name
     * @return bool True if the input is empty, false otherwise
     */
    private function emptyInputCheck($device_name) {
        //checks if the $device_name is empty
        if (empty($device_name)) {
            $result = true;
        } else {
            $result = false;
        }

        return $result;
    }

    /**
     * Checks if the visibility status is valid
     *
     * @param int $visible The visibility status
     * @return bool True if the visibility status is valid, false otherwise
     */
    private function isVisible($visible) {

        $result;
        //checks if the input is either 1 or 0
        if ($visible === 1 || $visible === 0){
            $result = true;
        } else {
            $result = false;
        }

        return $result;
    }

    /**
     * Checks if the device name is valid
     *
     * @param string $name The device name
     * @return bool True if the device name is valid, false otherwise
     */
    private function invalidName($name) {

        $result;
        //checks if the input contains special characters
        if(!preg_match("/^[a-zA-Z-0-9]*$/", $name)) {
            $result = false;
        } else {
            $result = true;
        }
        return $result;
    }


}
