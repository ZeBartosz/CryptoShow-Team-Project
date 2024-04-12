<?php

include_once "eventController.php";
class EventView extends EventController {

    private $controller;

    public function __construct($controller) {
        $this->controller = $controller;
    }
    public function displayAllEvents() {
        if (isset($_POST["search_event"])) {
            $search_keyword = $_POST["search_event"];
            $event_info = $this->controller->searchEventByKeyword($search_keyword);
        } else {
            $event_info = $this->controller->getAllEventInfo();
        }
        echo '<div class="content active">
            <h2>Events</h2>
            <table>
                <thead>
                    <tr>
                        <th>Event ID</th>
                        <th>Event Name</th>
                        <th>Event Description</th>
                        <th>Event Date</th>
                        <th>Event Venue</th>
                        <th>Published</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody>';
            if(!empty($event_info)) {
                foreach($event_info as $event) {
                    echo "<tr>
                            <td>" . $event['event_id'] . "</td>
                            <td>" . $event['event_date'] . "</td>
                            <td>" . $event['event_name'] . "</td>
                            <td>" . $event['event_venue'] . "</td>
                            <td>" . $event['event_description'] . "</td>
                            <td>" . ($event['is_published'] ? "Yes" : "No") . "</td>
                            <td><a href='./eventEdit.php?eventId=" . $event['event_id'] . "'><button>Edit</button></a></td>
                            <td>
                                <form method='post'>
                                    <input type='hidden' name='delete_event' value='" . $event['event_id'] . "'>
                                    <button type='submit' onclick=\"return confirm('Are you sure?')\">Delete</button>
                                </form>
                            </td>
                            <td>
                                <form method='post'>
                                    <button type='submit' name='publish' value='" . $event['event_id'] . "' onclick=\"return confirm('Are you sure?')\">Publish</button>
                                </form>
                            </td>
                        </tr>";
                }
            } else {
                echo "<tr>";
                echo "<td colspan='6'>No Record</td>";
                echo "</tr>";
            }
        echo '    </tbody> </table> </div>';
    }
}