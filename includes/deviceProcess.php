<?php

include_once "dbh.php";

class DeviceProcess extends Dbh
{

    protected function getDevicesInfo($userId)
    {

        $sql = "SELECT * FROM crypto_device WHERE fk_user_id = ?;";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(":userId", $userId, PDO::PARAM_STR);

        if (!$stmt->execute(array($userId))) {
            $stmt = null;
            header("Location: profile.php?error=stmtfailed");
            exit();
        }

        $DevicesData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $DevicesData;
    }

    protected function getSpecificDevicesInfo($deviceId)
    {

        $sql = "SELECT * FROM crypto_device WHERE crypto_device_id = ?;";
        $stmt = $this->connect()->prepare($sql);

        if (!$stmt->execute(array($deviceId))) {
            $stmt = null;
            header("Location: profile.php?error=stmtfailed");
            exit();
        }

        if ($stmt->rowCount() == 0) {
            $stmt = null;
            header("Location: profile.php?error=nothingInTheArray");
            exit();
        }

        $DevicesData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $DevicesData;
    }


    protected function setNewProfileInfo($device_name, $device_image_name, $crypto_device_record_visible, $device_id) {

        $stmt = $this->connect()->prepare('UPDATE crypto_device SET crypto_device_name = ?, crypto_device_image = ?, crypto_device_record_visible = ? WHERE crypto_device_id = ?;');

        if (!$stmt->execute(array($device_name, $device_image_name, $crypto_device_record_visible, $device_id))) {
            $stmt = null;
            header("Location: profile.php?error=stmtfaied");
            exit();
        }

        $stmt = null;

    }

    protected function deleteThisDevice($device_id) {

        $stmt = $this->connect()->prepare('DELETE FROM crypto_device WHERE crypto_device_id = ?;');

        if (!$stmt->execute(array($device_id))) {
            $stmt = null;
            header("Location: profile.php?error=stmtfaied");
            exit();
        }

        $stmt = null;

    }

    protected function setDevice($device_name, $device_image_name, $crypto_device_record_visible, $userid) {

        $stmt = $this->connect()->prepare('INSERT INTO crypto_device (fk_user_id, crypto_device_name, crypto_device_image, crypto_device_record_visible, crypto_device_registered_timestamp) VALUES  (?, ?, ?, ?, NOW());');

        $stmt->execute(array($userid, $device_name, $device_image_name, $crypto_device_record_visible));


        $stmt = null;

    }


    }
