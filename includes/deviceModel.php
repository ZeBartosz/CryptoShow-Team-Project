<?php

include_once "dbh.php";

class DeviceModel extends Dbh
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

        $stmt = $this->connect()->prepare('UPDATE crypto_device SET crypto_device_name = ?, crypto_device_image_name = ?, crypto_device_record_visible = ? WHERE crypto_device_id = ?;');

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

    protected function setDevice($device_name, $crypto_device_image_name, $crypto_device_record_visible, $userid) {

        $stmt = $this->connect()->prepare('INSERT INTO crypto_device (fk_user_id, crypto_device_name, crypto_device_image_name, crypto_device_record_visible, crypto_device_registered_timestamp) VALUES  (?, ?, ?, ?, NOW());');

        $stmt->execute(array($userid, $device_name, $crypto_device_image_name, $crypto_device_record_visible));


        $stmt = null;

    }

    public function getAllDeviceInfo()
    {
        try {
            $query = "SELECT * FROM crypto_device";
            $stmt = $this->connect()->prepare($query);
            $stmt->execute();

            $device_info = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $device_info;
        } catch (PDOException $e) {
            $_SESSION["message"] = "Error fetching all events: " . $e->getMessage();
        }
    }

    public function deleteDeviceInfo($device_id)
    {
        try {
            $query = "DELETE FROM crypto_device WHERE crypto_device_id=:deviceid";
            $stmt = $this->connect()->prepare($query);
            $stmt->bindParam(":deviceid", $device_id, PDO::PARAM_INT);
            $stmt->execute();

            header("location: ./admin.php");
            $_SESSION["message"] = "Device deleted successfully";
        } catch (PDOException $e) {
            header("location: ./admin.php");
            $_SESSION["message"] = "Error deleting device: " . $e->getMessage();
        }
    }
    
    public function searchDeviceByKeyword($search_keyword) {
        try {
            $query = "SELECT * FROM crypto_device WHERE crypto_device_name LIKE :search_keyword OR crypto_device_id LIKE :search_keyword";
            $stmt = $this->connect()->prepare($query);

            $stmt->bindParam(":search_keyword", $search_keyword, PDO::PARAM_STR);

            $stmt->execute(["search_keyword" => "%$search_keyword%"]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $_SESSION["message"] = "Error searching event info: " . $e->getMessage();
            header("location: ./admin.php?tab=devices");
            exit();
        }
    }


}
