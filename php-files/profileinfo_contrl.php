<?php


class ProfileInfoContrl extends ProfileInfo {

    private $userId;
    private $userName;

    public function __construct($userId, $userName) {
        $this->userId = $userId;
        $this->userName = $userName;
    }

    public function updateProfileInfo($userNickname, $userName, $userEmail) {
        if ($this->emptyInputCheck($userNickname, $userName, $userEmail)){
            header("location: ../profile.php?error=emptyinput");
            exit();
        }

        $this->setNewProfileInfo($this->$userId, $userNickname, $userName, $userEmail);

    }

    private function emptyInputCheck($userNickname, $userName, $userEmail){
        $result = null;
        if(empty($userNickname) || empty($userName) || empty($userEmail)) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }
}
