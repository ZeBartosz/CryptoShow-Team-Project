<?php

class DeviceView extends DeviceProcess {


    public function fetchDeviceName($userId){
        $profileInfo = $this->getDevicesInfo($userId);

        echo $profileInfo[0]["crypto_device_name"];
    }

    public function fetchDeviceImagine($userId){
        $profileInfo = $this->getDevicesInfo($userId);

        echo $profileInfo[0]["crypto_device_image"];
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

}
