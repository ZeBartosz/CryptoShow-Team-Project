<?php

include_once "profileModel.php"
/**
 * Class ProfileView
 * Handles the view logic for profile-related information
 * @extends ProfileModel allows the use of read function
 */
class ProfileView extends ProfileModel {

    /**
     * Fetch user's nickname by user ID
     *
     * @param int $userId The ID of the user
     * @return string The nickname of the user
     */
    public function fetchNickname($userId){
        $profileInfo = $this->getProfileInfo($userId);

        return $profileInfo[0]["user_nickname"];
    }

    /**
     * Fetches user's name by user ID and display it
     *
     * @param int $userId The ID of the user
     */
    public function fetchName($userId){
        $profileInfo = $this->getProfileInfo($userId);
        //echos the result in the first row
        echo $profileInfo[0]["user_name"];
    }

    /**
     * Fetches user's email by user ID
     *
     * @param int $userId The ID of the user
     * @return string The email of the user
     */
    public function fetchEmail($userId){
        $profileInfo = $this->getProfileInfo($userId);

        return $profileInfo[0]["user_email"];
    }

    /**
     * Fetches user's image file location by user ID
     *
     * @param string $userId The ID of the user
     * @return string The image file location of the user
     */
    public function fetchImage($userId){
        $profileInfo = $this->getProfileInfo($userId);

        return $profileInfo[0]["user_image"];
    }

    /**
     * Fetches user's bio by user ID
     *
     * @param int $userId The ID of the user
     * @return string The bio of the user
     */
    public function fetchBio($userId){
        $profileInfo = $this->getProfileInfo($userId);

        return $profileInfo[0]["user_description"];
    }

    /**
     * Fetches user's device count by user ID
     *
     * @param int $userId The ID of the user
     * @return int The device count of the user
     */
    public function fetchDeivceCount($userId){
        $profileInfo = $this->getProfileInfo($userId);

        return $profileInfo[0]["user_device_count"];
    }

    /**
     * Fetches profile information by username
     *
     * @param string $username The username of the user
     * @return array The profile information as an  array
     */
    public function fetchPublicProfileInfo($username) {
        return $this->getPublicProfileInfo($username);
    }


}
