<?php

include_once "userController.php";

/**
 * Represents the view layer for displaying user-related data.
 *
 * This class handles the presentation of user information, including search results
 * and lists of attending users for specific events.
 */
class UserView extends UserController {

    private $controller;

    
    /**
     * Initializes a new instance of the UserView class.
     *
     * @param UserController $controller The controller that will provide data to this view.
     */
    public function __construct($controller) {
        $this->controller = $controller;
    }

    /**
     * Displays all user information in a tabulated format.
     *
     * If a search keyword is posted, it displays search results; otherwise, it displays all users.
     * This method directly outputs HTML to render the information.
     */
    public function displayAllUserInfo() {
        if (isset($_POST["search_user"])) {
            $search_keyword = $_POST["search_user"];
            $user_info = $this->controller->searchUserByKeyword($search_keyword);
        } else {
            $user_info = $this->controller->getAllUserInfo();
        }
        echo '<div class="content active">
            <h2>Users</h2>
            <table>
                <thead>
                    <tr>
                        <th>Admin</th>
                        <th>User ID</th>
                        <th>Nickname</th>
                        <th>Fullname</th>
                        <th>Email</th>
                        <th>Device count</th>
                        <th>Registered</th>
                        <th colspan ="2">Edit</th>
                    </tr>
                </thead>
                <tbody>';
        if (!empty($user_info)) {
            foreach ($user_info as $user) {
                echo "<tr>
                    <td>" . ($user['is_admin'] ? "Yes" : "No") . "</td>
                    <td>" . $user['user_id'] . "</td>
                    <td>" . $user['user_nickname'] . "</td>
                    <td>" . $user['user_name'] . "</td>
                    <td>" . $user['user_email'] . "</td>
                    <td>" . $user['user_device_count'] . "</td>
                    <td>" . $user['user_registered_timestamp'] . "</td>
                    <td><a href='userEdit.php?id=" . $user['user_id'] . "'><button type= 'submit'>Edit</button></a>
                    
                        <form method='post'>
                            <input type='hidden' name='delete_user' value='" . $user['user_id'] . "'>
                            <button type='delete' onclick=\"return confirm('Are you sure?')\">Delete</button>
                        </form>
                    </td>
                </tr>";
            }
        } else {
            echo "<tr>";
            echo "<td colspan='8'>No Record</td>";
            echo "</tr>";
        }
        echo '</tbody></table></div>';
    }

    /**
     * Displays users attending a specific event.
     *
     * The method retrieves user information of attendees and displays it with links to their profiles
     * and profile images. If no users are attending, a message is displayed.
     *
     * @param int $event_id The event identifier to find attending users for.
     */
    public function displayAttendingUsers($event_id)
    {
        $user_info = $this->controller->getAllAttendingUsers($event_id);
        if (!empty($user_info)) {
            echo '<table>
                    <thead>
                        <tr>
                            <th>User who will be attending</th>
                        </tr>
                    </thead>
                    </tbody>';
            $user_info = $this->controller->getForeignUserInfo($user_info);
            foreach ($user_info as $user) {
                if (!empty($user["user_image"])) {
                echo"<tr>
                        <td>
                            <div class='user-tag'>
                            <img class='user-img' src='" . $user['user_image'] . "' alt='User Image'>
                            <a href='profile.php?username=" . $user['user_nickname'] . "'>" . $user['user_nickname'] . "</a>
                        </div>
                        </td>
                    </tr>";
                }else{
                echo"<tr>
                        <td>
                            <div class='user-tag'>
                            <img class='user-img' src='./images/login.png' alt='User Image'>
                            <a href='profile.php?username=" . $user['user_nickname'] . "'>" . $user['user_nickname'] . "</a>
                        </div>
                        </td>
                    </tr>";}
                      
            }
        } else {
            echo '<table>
                    <thead>
                        <tr>
                            <th>No attending Users</th>
                        </tr>
                    </thead>
                    </tbody>';
        }
    }
}
