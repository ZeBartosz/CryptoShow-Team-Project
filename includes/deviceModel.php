<?php

include_once "dbh.php";

/**
 * Class DeviceModel
 * This class handles operations related to device information in the database
 * @extends dbh Connection to the database
 */
class DeviceModel extends Dbh {

    /**
     * Retrieves information about devices from a specific user
     *
     * @param int $userId The ID of the user
     * @return array An array containing device information
     */
    protected function getDevicesInfo($userId) {

        //query for the database
        $sql = "SELECT * FROM crypto_device WHERE fk_user_id = ?;";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(":userId", $userId, PDO::PARAM_STR);

        //Executing the query
        //Checking if the statement has been executed, if not returns to profile.php
        if (!$stmt->execute(array($userId))) {
            $stmt = null;
            header("Location: profile.php?error=stmtfailed");
            exit();
        }

        //fetches an array containing all the rows
        $DevicesData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $DevicesData;
    }

    /**
     * Retrieves specific information about a device
     *
     * @param int $deviceId The ID of the device
     * @return array An array containing device information
     */
    protected function getSpecificDevicesInfo($deviceId) {

        //query for the database
        $sql = "SELECT * FROM crypto_device WHERE crypto_device_id = ?;";
        $stmt = $this->connect()->prepare($sql);

        //Executing the query
        //Checking if the statement has been executed, if not returns to profile.php
        if (!$stmt->execute(array($deviceId))) {
            $stmt = null;
            header("Location: profile.php?error=stmtfailed");
            exit();
        }

        //fetches an array containing all the rows
        $DevicesData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $DevicesData;
    }

    /**
     * Retrieves device information from a specific user and if the device is set to visible(1)
     *
     * @param int $userId The ID of the user
     * @return array An array containing public device information
     */
    protected function getPublicDeviceInfo($userId) {

        //query for the database
        $sql = "SELECT * FROM crypto_device WHERE fk_user_id = ? AND crypto_device_record_visible = 1;";
        $stmt = $this->connect()->prepare($sql);

        //Executing the query
        //Checking if the statement has been executed, if not returns to profile.php
        if (!$stmt->execute(array($userId))) {
            $stmt = null;
            header("Location: index.php?error=stmtfailed");
            exit();
        }

        //fetches an array containing all the rows
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Updates information of a device
     *
     * @param string $device_name The name of the device
     * @param string $device_image_name The location of the device image
     * @param int $crypto_device_record_visible Visibility status of the device
     * @param int $device_id The ID of the device
     */
    protected function setNewProfileInfo($device_name, $device_image_name, $crypto_device_record_visible, $device_id) {

        //query for the database
        $stmt = $this->connect()->prepare('UPDATE crypto_device SET crypto_device_name = ?, crypto_device_image_name = ?, crypto_device_record_visible = ? WHERE crypto_device_id = ?;');

        //Executing the query
        //Checking if the statement has been executed, if not returns to profile.php
        if (!$stmt->execute(array($device_name, $device_image_name, $crypto_device_record_visible, $device_id))) {
            $stmt = null;
            header("Location: profile.php?error=stmtfaied");
            exit();
        }

        //sets stmt to null
        $stmt = null;

    }

    /**
     * Deletes a device from the database
     *
     * @param int $device_id The ID of the device
     */
    protected function deleteThisDevice($device_id) {

        //query for the database
        $stmt = $this->connect()->prepare('DELETE FROM crypto_device WHERE crypto_device_id = ?;');

        //Executing the query
        //Checking if the statement has been executed, if not returns to profile.php
        if (!$stmt->execute(array($device_id))) {
            $stmt = null;
            header("Location: profile.php?error=stmtfaied");
            exit();
        }

        //sets stmt to null
        $stmt = null;

    }

    /**
     * Searches for devices in the database based on a keyword.
     *
     * @param string $search_keyword The keyword to search for
     * @return array An array containing information about devices matching the search keyword
     */
    protected function setDevice($device_name, $crypto_device_image_name, $crypto_device_record_visible, $userid) {

        //query for the database
        $stmt = $this->connect()->prepare('INSERT INTO crypto_device (fk_user_id, crypto_device_name, crypto_device_image_name, crypto_device_record_visible, crypto_device_registered_timestamp) VALUES  (?, ?, ?, ?, NOW());');

        //Execute the query
        $stmt->execute(array($userid, $device_name, $crypto_device_image_name, $crypto_device_record_visible));

        //sets stmt to null
        $stmt = null;

    }

    /**
     * Retrieves information about all the devices from the database, used in admin.php
     *
     * @return array An array containing information about all the devices
     */
    protected function getAllDeviceInfo()
    {
        try {
            //query for the database
            $query = "SELECT * FROM crypto_device";
            $stmt = $this->connect()->prepare($query);

            //Execute the query
            $stmt->execute();
            //fetches an array containing all the rows
            $device_info = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $device_info;

            //catches any errors
        } catch (PDOException $e) {
            $_SESSION["message"] = "Error fetching all events: " . $e->getMessage();
        }
    }

    /**
     * Deletes information about a specific device from the database, used in admin.php
     *
     * @param int $device_id The ID of the device
     */
    protected function deleteDeviceInfo($device_id)
    {
        try {
            //query for the database
            $query = "DELETE FROM crypto_device WHERE crypto_device_id=:deviceid";
            $stmt = $this->connect()->prepare($query);
            $stmt->bindParam(":deviceid", $device_id, PDO::PARAM_INT);

            //Execute the query
            $stmt->execute();

            //If Successful send admin back to admin.php
            header("location: ./admin.php");
            $_SESSION["message"] = "Device deleted successfully";

            //catches any errors
        } catch (PDOException $e) {
            header("location: ./admin.php");
            $_SESSION["message"] = "Error deleting device: " . $e->getMessage();
        }
    }

    /**
     * Searches for a device in the database based on a keyword, used in admin.php
     *
     * @param string $search_keyword The keyword to search for
     * @return array An array containing information about devices matching the search keyword
     */
    protected function fetchSearchDeviceByKeyword($search_keyword) {
        try {
            //query for the database
            $query = "SELECT * FROM crypto_device WHERE crypto_device_name LIKE :search_keyword OR crypto_device_id LIKE :search_keyword";
            $stmt = $this->connect()->prepare($query);

            $stmt->bindParam(":search_keyword", $search_keyword, PDO::PARAM_STR);

            //Execute the query
            $stmt->execute(["search_keyword" => "%$search_keyword%"]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

            //catches any errors
        } catch (PDOException $e) {
            $_SESSION["message"] = "Error searching event info: " . $e->getMessage();
            header("location: ./admin.php?tab=devices");
            exit();
        }
    }


}
