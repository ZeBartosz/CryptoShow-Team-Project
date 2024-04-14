<?php

include_once "userController.php";
class UserView extends UserController {

    private $controller;

    public function __construct($controller) {
        $this->controller = $controller;
    }
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
                    <td><a href='userEdit.php?id=" . $user['user_id'] . "'><button type= 'submit'>Edit</button></a></td>
                    <td>
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
                    <tbody>';
            $user_info = $this->controller->getForeignUserInfo($user_info);
            foreach ($user_info as $user) {
                echo "<tr>
                        <td><a href='profile.php?username=".$user['user_nickname']."'>".$user['user_nickname']."</a></td>
                      </tr>";
            }
        } else {
            echo '<table>
                    <thead>
                        <tr>
                            <th>No attending Users</th>
                        </tr>
                    </thead>
                    <tbody>';
        }
    }
}
