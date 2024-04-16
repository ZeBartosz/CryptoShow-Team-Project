<?php

include_once "dbh.php";

/**
 * EventModel handles all database interactions related to events within the application.
 * 
 * This class extends from Dbh (Database Handler), which manages database connections. It
 * provides methods for CRUD operations related to event management such as adding, updating,
 * deleting, publishing, and retrieving event data.
 */
class EventModel extends Dbh {

    /**
     * Deletes an event based on its ID.
     *
     * @param int $event_id The ID of the event to be deleted.
     */
    protected function deleteEvent($event_id){
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

    /**
     * Publishes an event by setting its 'is_published' status to true.
     *
     * @param int $event_id The ID of the event to be published.
     */
    protected function setPublishEvent($event_id) {
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

    /**
     * Books an event for a user by inserting a record into the user_event table.
     *
     * @param int $user_id The user's ID.
     * @param int $event_id The event's ID.
     */
    protected function setbookEvent($user_id, $event_id) {
        try {
            $query = "INSERT INTO user_event (fk_user_id, fk_event_id) VALUES (?, ?);";
            $stmt = $this->connect()->prepare($query);

            $stmt->execute(array($user_id, $event_id));
        } catch (PDOException $e) {
            header("location: ./eventList.php");
            $_SESSION["message"] = "Error booking an event: " . $e->getMessage();
        }
    }

    /**
     * Retrieves all event information from the database.
     *
     * @return array|void An array of all event data or void if an error occurs.
     */
    protected function getAllEventInfo() {
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

    /**
     * Retrieves a single event by its ID.
     *
     * @param int $event_id The ID of the event to fetch.
     * @return array|null Event data or null if an error occurs.
     */
    protected function getEvent($event_id) {
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

    /**
     * Updates an event's details in the database.
     *
     * @param int $event_id The ID of the event.
     * @param string $event_name The name of the event.
     * @param string $event_description The description of the event.
     * @param string $event_date The date of the event.
     * @param string $event_venue The venue of the event.
     * @return bool True on successful update.
     */
    protected function setEventInfo($event_id, $event_name, $event_description, $event_date, $event_venue) {
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

    /**
     * Adds a new event to the database.
     *
     * @param string $event_name The name of the event.
     * @param string $event_description The description of the event.
     * @param string $event_date The date of the event.
     * @param string $event_venue The venue of the event.
     * @param bool $is_published Whether the event is published.
     * @return bool True on successful addition.
     */
    protected function addEvent($event_name, $event_description, $event_date, $event_venue, $is_published) {
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

    /**
     * Searches for events in the database by a keyword that matches multiple fields.
     *
     * @param string $search_keyword The keyword to search for.
     * @return array|void An array of events that match the keyword, or void if an error occurs.
     */
    protected function searchEventByKeyword($search_keyword) {
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
