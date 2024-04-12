<?php

include_once "dbh.php";
class EventModel extends Dbh {

    public function deleteEvent($event_id){
        try {
            $query = "DELETE FROM event WHERE event_id = :eventid";
            $stmt = $this->connect()->prepare($query);
            $stmt->bindParam(":eventid", $event_id, PDO::PARAM_INT);

            $stmt->execute();

            $_SESSION["message"] = "Event deleted successfully";
        } catch (PDOException $e) {
            header("location: ./admin.php");
            $_SESSION[""] = "Error deleting event: " . $e->getMessage();
        }
    }

    public function publishEvent($event_id) {
        try {
            $query = "UPDATE event SET is_published = 1 WHERE event_id = :eventid";
            $stmt = $this->connect()->prepare($query);
            $stmt->bindParam(":eventid", $event_id, PDO::PARAM_INT);

            $stmt->execute();
            $_SESSION["message"] = "Event published successfully";
        } catch (PDOException $e) {
            header("location: ./admin.php");
            $_SESSION[""] = "Error publishing event: " . $e->getMessage();
        }
    }

    public function getAllEventInfo() {
        try {
            $query = "SELECT * FROM event";
            $stmt = $this->connect()->prepare($query);
            $stmt->execute();

            $event_info = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $event_info;
        } catch (PDOException $e) {
            $_SESSION["message"] = "Error fetching all events: " . $e->getMessage();
        }
    }

    public function getEvent($event_id) {
        try {
            $query = "SELECT * FROM event WHERE event_id = :event_id";
            $stmt = $this->connect()->prepare($query);
            $stmt->bindParam(":event_id", $event_id, PDO::PARAM_INT);

            $stmt->execute();

            $event_info = $stmt->fetch(PDO::FETCH_ASSOC);
            return $event_info;
        } catch (PDOException $e) {
            $_SESSION["message"] = "Error fetching event: " . $e->getMessage();
        }
    }

    public function setEventInfo($event_id, $event_name, $event_description, $event_date, $event_venue) {
        try {
            $query = "UPDATE event SET event_name = :event_name, event_description = :event_description, event_date = :event_date, event_venue = :event_venue WHERE event_id = :event_id";
            $stmt = $this->connect()->prepare($query);

            $stmt->bindParam(':event_name', $event_name, PDO::PARAM_STR);
            $stmt->bindParam(':event_description', $event_description, PDO::PARAM_STR);
            $stmt->bindParam(':event_date', $event_date, PDO::PARAM_STR);
            $stmt->bindParam(':event_venue', $event_venue, PDO::PARAM_STR);
            $stmt->bindParam(":event_id", $event_id, PDO::PARAM_INT);

            $stmt->execute();
            return true;

        }catch (PDOException $e) {
            $_SESSION["message"] = "Error editing event info: " . $e->getMessage();
            header("location: ./admin.php");
            exit();
        }
    }

    public function addEvent($event_name, $event_description, $event_date, $event_venue, $is_published) {
        try {
            $query = "INSERT INTO event (event_name, event_date, event_description, event_venue, is_published) VALUES (:event_name, :event_date, :event_description, :event_venue, :is_published) ";
            $stmt = $this->connect()->prepare($query);

            $stmt->bindParam('event_name', $event_name,PDO::PARAM_STR);
            $stmt->bindParam(':event_description', $event_description, PDO::PARAM_STR);
            $stmt->bindParam(':event_date', $event_date, PDO::PARAM_STR);
            $stmt->bindParam(':event_venue', $event_venue, PDO::PARAM_STR);
            $stmt->bindParam(':is_published', $is_published, PDO::PARAM_STR);

            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            $_SESSION["message"] = "Error adding event info: " . $e->getMessage();
            header("location: ./admin.php");
            exit();
        }
    }

    public function searchEventByKeyword($search_keyword) {
        try {
            $query = "SELECT * FROM event WHERE event_name LIKE :search_keyword OR event_description LIKE :search_keyword OR event_venue LIKE :search_keyword OR event_id LIKE :search_keyword";
            $stmt = $this->connect()->prepare($query);

            $stmt->bindParam(":search_keyword", $search_keyword, PDO::PARAM_STR);

            $stmt->execute(["search_keyword" => "%$search_keyword%"]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $_SESSION["message"] = "Error searching device info: " . $e->getMessage();
            header("location: ./admin.php?tab=events");
            exit();
        }
    }

}
