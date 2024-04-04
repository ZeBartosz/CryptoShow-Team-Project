<?php

class DeviceView extends DeviceProcess {

    public function fetchAllDevices($userId){
        $profileInfo = $this->getDevicesInfo($userId);
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

}
