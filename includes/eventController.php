<?php

include_once "eventModel.php";

/**
 * The controller part of the MVC pattern, handling event-related operations.
 *
 * This class manages interactions between the view layer and the model,
 * handling business logic and application rules related to user data.
 */
class EventController extends EventModel {

    private $model;

    private $user_id;
    
    private $event_id;

    /**
     * Constructor to initialize the EventController class.
     */
    public function __construct() {
        $this->model = new EventModel();
    }
    
    /**
     * Sets the user ID to link user-related event actions.
     *
     * @param int $user_id The user's ID.
     */
    public function setUserForeignId($user_id) {
        $this->user_id = $user_id;
    }

    /**
     * Sets the event ID to link event-specific actions.
     *
     * @param int $event_id The event's ID.
     */
    public function setEventForeignId($event_id) {
        $this->event_id = $event_id;
    }

    /**
     * Retrieves all event information from the model.
     *
     * @return array|null Event data or null if an error occurs.
     */
    public function getAllEventInfo() {
        try {
            return $this->model->getAllEventInfo();
        } catch (PDOException $e) {
            $_SESSION["message"] = "Error fetching Events: ". $e->getMessage();
        }
    }

    /**
     * Searches for events by a given keyword.
     *
     * @param string $search_keyword The keyword to search for in events.
     * @return array|null Searched event data or null if an error occurs.
     */
    public function searchEventByKeyword($search_keyword) {
        try {
            return $this->model->searchEventByKeyword($search_keyword);
        } catch (PDOException $e) {
            $_SESSION["message"] = "Error searching device info: " . $e->getMessage();
            header("Location: admin.php?tab=events");
            exit();
        }
    }

    /**
     * Retrieves details of a specific event by its ID.
     *
     * @param int $event_id The ID of the event to retrieve.
     * @return array|null Details of the event or null if an error occurs.
     */
    public function getEvent($event_id){
        try {
            return $this->model->getEvent($event_id);
        }catch (PDOException $e) {
            $_SESSION["message"] = "Error fetching Events: ". $e->getMessage();
        }
    }

    /**
     * Deletes a specific event by its ID.
     *
     * @param int $event_id The ID of the event to delete.
     */
    public function deleteEvent($event_id)
    {
        $this->model->deleteEvent($event_id);
    }

    /**
     * Books an event for a user.
     *
     * @param int $user_id The user's ID who is booking the event.
     * @param int $event_id The ID of the event to book.
     */
    public function bookEvent($user_id, $event_id) {
        $this->model->setbookEvent($user_id, $event_id);
    }

    /**
     * Publishes an event to make it visible publicly.
     *
     * @param int $event_id The ID of the event to publish.
     */
    public function publishEvent($event_id) {
        $this->model->setPublishEvent($event_id);
    }

    /**
     * Sets or updates information for an existing event.
     *
     * Validates inputs and redirects with an error message on validation failure,
     * otherwise, updates the event information in the database.
     *
     * @param int $event_id The ID of the event.
     * @param string $event_name The name of the event.
     * @param string $event_description A description of the event.
     * @param string $event_date The date of the event.
     * @param string $event_venue The venue of the event.
     * @return mixed The result of the model operation or redirect on failure.
     */
    public function setEventInfo($event_id, $event_name, $event_description, $event_date, $event_venue) {

        $result = $this->hasEmptyInput($event_description, $event_name, $event_date, $event_venue);
        if($result === true) {
            $_SESSION["message"] = "Error Empty Input";
            header("location: ./eventEdit.php?eventId=$event_id");
            exit();
        }

        $result = $this->reachedDescriptionLimit($event_description);
        if($result === true) {
            $_SESSION["message"] = "Error Description Too Long";
            header("location: ./eventEdit.php?eventId=$event_id");
            exit();
        }

        $result = $this->isValidEventName($event_name);
        if($result === false) {
            $_SESSION["message"] = "Error Invalid Event Name";
            header("location: ./eventEdit.php?eventId=$event_id");
            exit();
        }

        $result = $this->isValidVenue($event_venue);
        if($result === false) {
            $_SESSION["message"] = "Error Invalid Venue Name";
            header("location: ./eventEdit.php?eventId=$event_id");
            exit();
        }

        $result = $this->isValidDateFormat($event_date);
        if($result === false) {
            $_SESSION["message"] = "Error Invalid Date";
            header("location: ./eventEdit.php?eventId=$event_id");
            exit();
        }


        return $this->model->setEventInfo($event_id, $event_name, $event_description, $event_date, $event_venue);
    }

    /**
     * Adds a new event to the system.
     *
     * Validates the input fields for an event and, if validation passes, adds the event
     * to the database. Redirects with an error message on validation failure.
     *
     * @param string $event_name The name of the event.
     * @param string $event_description A description of the event.
     * @param string $event_date The date of the event.
     * @param string $event_venue The venue of the event.
     * @param bool $is_published Whether the event is initially published.
     * @return mixed The result of the model operation or redirect on failure.
     */
    public function addEvent($event_name, $event_description, $event_date, $event_venue, $is_published) {

        $result = $this->hasEmptyInput($event_description, $event_name, $event_date, $event_venue);
        if($result === true) {
            $_SESSION["message"] = "Error Empty Input";
            header("location: ./addEvent.php");
            exit();
        }

        $result = $this->reachedDescriptionLimit($event_description);
        if($result === true) {
            $_SESSION["message"] = "Error Description Too Long";
            header("location: ./addEvent.php");
            exit();
        }

        $result = $this->isValidEventName($event_name);
        if($result === false) {
            $_SESSION["message"] = "Error Invalid Event Name";
            header("location: ./addEvent.php");
            exit();
        }

        $result = $this->isValidVenue($event_venue);
        if($result === false) {
            $_SESSION["message"] = "Error Invalid Venue Name";
            header("location: ./addEvent.php");
            exit();
        }

        $result = $this->isValidDateFormat($event_date);
        if($result === false) {
            $_SESSION["message"] = "Error Invalid Date";
            header("location: ./addEvent.php");
            exit();
        }

        return $this->model->addEvent($event_name, $event_description, $event_date, $event_venue, $is_published);
    }

    /**
     * Checks for empty input fields.
     *
     * @param string $event_description The event description.
     * @param string $event_name The name of the event.
     * @param string $event_date The date of the event.
     * @param string $event_venue The venue of the event.
     * @return bool True if any field is empty, otherwise false.
     */
    private function hasEmptyInput($event_description, $event_name, $event_date, $event_venue) {
        $result;
        if(empty($event_description) || empty($event_name) || empty($event_date) || empty($event_venue)) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    /**
     * Checks if the event description exceeds the maximum allowed length.
     *
     * @param string $event_description The event description to check.
     * @return bool True if the description is too long, otherwise false.
     */
    private function reachedDescriptionLimit($event_description) {
        $result;
        if(strlen($event_description) > 255) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    /**
     * Validates the format of the event name.
     *
     * @param string $event_name The event name to validate.
     * @return bool True if the name is valid, otherwise false.
     */
    private function isValidEventName($event_name) {
        $result;
        if(preg_match("/^[a-zA-Z-0-9\s]*$/", $event_name)) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    /**
     * Validates the format of the event venue name.
     *
     * @param string $event_venue The venue name to validate.
     * @return bool True if the venue name is valid, otherwise false.
     */
    private function isValidVenue($event_venue) {
        $result;
        if(preg_match("/^[a-zA-Z-0-9\s]*$/", $event_venue)) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    /**
     * Validates the format of the event date.
     *
     * @param string $event_date The date to validate.
     * @return bool True if the date format is correct, otherwise false.
     */
    private function isValidDateFormat($event_date) {
        $result;
        if(preg_match("/^\d{4}-\d{2}-\d{2}$/", $event_date)) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }


}
