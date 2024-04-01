<?php


class ProfileInfoView extends ProfileInfo {

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


}
