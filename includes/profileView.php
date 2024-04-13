<?php

class ProfileView extends ProfileModel {

    public function fetchNickname($userId){
        $profileInfo = $this->getProfileInfo($userId);

        echo $profileInfo[0]["user_nickname"];
    }

    public function fetchName($userId){
        $profileInfo = $this->getProfileInfo($userId);

        echo $profileInfo[0]["user_name"];
    }

    public function fetchEmail($userId){
        $profileInfo = $this->getProfileInfo($userId);

        echo $profileInfo[0]["user_email"];
    }

    public function fetchDeivceCount($userId){
        $profileInfo = $this->getProfileInfo($userId);

        return $profileInfo[0]["user_device_count"];
    }


}