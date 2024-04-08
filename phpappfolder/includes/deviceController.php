<?php

class DeviceController extends DeviceProcess
{

    private $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    public function updateDeivce($device_name, $device_image_name, $crypto_device_record_visible, $deviceID)
    {
        if ($this->emptyInputCheck($device_name, $device_image_name, $crypto_device_record_visible)) {
            header("location: profile.php?error=emptyinput");
            exit();
        }

        $this->setNewProfileInfo($device_name, $device_image_name, $crypto_device_record_visible, $deviceID);

    }

    public function insertDevice($device_name, $device_image_name, $crypto_device_record_visible){
        if ($this->emptyInputCheck($device_name, $device_image_name, $crypto_device_record_visible)) {
            header("location: profile.php?error=emptyinput");
            exit();
        }

        $this->setDevice($device_name, $device_image_name, $crypto_device_record_visible, $this->userId);
    }

    public function deleteDevice($deviceId){
        if (empty($deviceId)) {
            header("location: profile.php?error=emptyinput");
            exit();
        } else {
            $this->deleteThisDevice($deviceId);
        }
    }



    private function emptyInputCheck($device_name, $device_image_name, $crypto_device_record_visible)
    {
        if (empty($device_name) || empty($device_image_name) || empty($crypto_device_record_visible)) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

}
