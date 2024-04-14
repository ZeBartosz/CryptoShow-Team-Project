<?php

include_once "deviceModel.php";
class DeviceController extends DeviceModel
{

    private $userId;
    private $model;

    public function __construct()
    {
        $this->model = new DeviceModel();
    }

    public function setForeignId($userId)
    {
        $this->userId = $userId;
    }

    public function updateDeivce($device_name, $device_image_name, $crypto_device_record_visible, $deviceID)
    {
        if ($this->emptyInputCheck($device_name)) {
            header("location: profile.php?error=emptyinput");
            exit();
        }

        if(!$this->is($crypto_device_record_visible)) {
        header("location: profile.php?error=invalidInput");
        exit();
        }

        if(!$this->invalidName($device_name)) {
            header("location: profile.php?error=invalidInput");
            exit();
        }




        $this->setNewProfileInfo($device_name, $device_image_name, $crypto_device_record_visible, $deviceID);

    }

    public function insertDevice($device_name, $device_image_name, $crypto_device_record_visible){
        if ($this->emptyInputCheck($device_name)) {
            header("location: profile.php?error=emptyinput");
            exit();
        }

        $result = $this->isVisible($crypto_device_record_visible);
        if($result === false) {
            header("location: profile.php?error=invalidInput");
            exit();
        }

        if(!$this->invalidName($device_name)) {
            header("location: profile.php?error=invalidInput");
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

    public function searchDeviceByKeyword($search_keyword) {
        try {
            return $this->model->searchDeviceByKeyword($search_keyword);
        } catch (PDOException $e) {
            $_SESSION["message"] = "Error searching device info: " . $e->getMessage();
            header("Location: admin.php?tab=devices");
            exit();
        }
    }

    private function emptyInputCheck($device_name)
    {
        if (empty($device_name)) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    private function isVisible($visible){
        $result;
        if ($visible === 1 || $visible === 0){
            $result = true;
        } else {
            $result = false;
        }

        return $result;
    }

    private function invalidName($name) {
        $result;
        if(!preg_match("/^[a-zA-Z-0-9]*$/", $name)) {
            $result = false;
        } else {
            $result = true;
        }
        return $result;
    }


}
