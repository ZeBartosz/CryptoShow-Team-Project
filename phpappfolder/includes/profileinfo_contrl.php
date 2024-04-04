<?php


class ProfileInfoContrl extends ProfileInfo
{

    private $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    public function updateProfileInfo($userNickname, $userName, $userEmail)
    {
        if ($this->emptyInputCheck($userNickname, $userName, $userEmail)) {
            header("location: ../profile.php?error=emptyinput");
            exit();
        }

        if (!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
            header("location: profile.php?error=invemail");
            exit();
        }

        $this->setNewProfileInfo($this->userId, $userNickname, $userName, $userEmail);

    }

    private function emptyInputCheck($userNickname, $userName, $userEmail)
    {
        $result = null;
        if (empty($userNickname) || empty($userName) || empty($userEmail)) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

}
