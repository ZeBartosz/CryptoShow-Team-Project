<?php

include_once "eventModel.php";
class EventController extends EventModel {

    private $model;

    private $user_id;
    
    private $event_id;

    public function setUserForeignId($user_id) {
        $this->user_id = $user_id;
    }

    public function setEventForeignId($event_id) {
        $this->event_id = $event_id;
    }

    public function __construct() {
        $this->model = new EventModel();
    }

    public function getAllEventInfo() {
        try {
            return $this->model->getAllEventInfo();
        } catch (PDOException $e) {
            $_SESSION["message"] = "Error fetching Events: ". $e->getMessage();
        }
    }

    public function searchEventByKeyword($search_keyword) {
        try {
            return $this->model->searchEventByKeyword($search_keyword);
        } catch (PDOException $e) {
            $_SESSION["message"] = "Error searching device info: " . $e->getMessage();
            header("Location: admin.php?tab=events");
            exit();
        }
    }

    public function getEvent($event_id){
        try {
            return $this->model->getEvent($event_id);
        }catch (PDOException $e) {
            $_SESSION["message"] = "Error fetching Events: ". $e->getMessage();
        }
    }

    public function deleteEvent($event_id)
    {
        $this->model->deleteEvent($event_id);
    }

    public function bookEvent($user_id, $event_id) {
        $this->model->setbookEvent($user_id, $event_id);
    }

    public function publishEvent($event_id) {
        $this->model->setPublishEvent($event_id);
    }

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

    private function hasEmptyInput($event_description, $event_name, $event_date, $event_venue) {
        $result;
        if(empty($event_description) || empty($event_name) || empty($event_date) || empty($event_venue)) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    private function reachedDescriptionLimit($event_description) {
        $result;
        if(strlen($event_description) > 255) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    private function isValidEventName($event_name) {
        $result;
        if(preg_match("/^[a-zA-Z-0-9\s]*$/", $event_name)) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    private function isValidVenue($event_venue) {
        $result;
        if(preg_match("/^[a-zA-Z-0-9\s]*$/", $event_venue)) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

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
