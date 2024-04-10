<?php

include_once "eventController.php";
class EventView extends EventController {

    private $controller;

    public function __construct($controller) {
        $this->controller = $controller;
    }
    public function displayAllEvents() {
        $event_info = $this->controller->getAllEvents();

        if($event_info) {
            foreach($event_info as $event) {
                echo "<tr>";
                echo "<td>" . ($event['event_id']) . "</td>";
                echo "<td>" . ($event['event_date']) . "</td>";
                echo "<td>" . htmlspecialchars($event['event_name']) . "</td>";
                echo "<td>" . htmlspecialchars($event['event_venue']) . "</td>";
                echo "<td>" . ($event['event_description']) . "</td>";
                echo "<td>" . ($event['is_published'] ? "Yes" : "No") . "</td>";
                echo "<td><a href='./eventEdit.php?eventId=" . $event['event_id'] . "'><button>Edit</button></a></td>";
                echo '<td>
                        <form method="post">
                            <input type="hidden" name="delete_event" value="' . $event['event_id'] . '">
                            <button type="submit" onclick="return confirm(\'Are you sure?\')">Delete</button>
                        </form>
                    </td>';
                echo '<td>
                        <form method="post">
                            <button type="submit" name="publish" value="' . $event['event_id'] . '" onclick="return confirm(\'Are you sure?\')">Publish</button>
                        </form>
                      </td>';
                echo "</tr>";
            }
            return true;
        }
    }
}