<?php

include_once "userController.php";
class UserView extends UserController {

    private $controller;

    public function __construct($controller) {
        $this->controller = $controller;
    }
    public function displayAllUserInfo() {
        $user_info = $this->controller->getAllUserInfo();

        if($user_info) {
            foreach($user_info as $user) {
                echo "<tr>";
                echo "<td>" . ($user['is_admin'] ? "Yes" : "No") . "</td>";
                echo "<td>" . ($user['user_id']) . "</td>";
                echo "<td>" . $user['user_nickname'] . "</td>";
                echo "<td>" . $user['user_name'] . "</td>";
                echo "<td>" . $user['user_email'] . "</td>";
                echo "<td>" . ($user['user_device_count']) . "</td>";
                echo "<td>" . ($user['user_registered_timestamp']) . "</td>";
                echo "<td><a href='userEdit.php?id=" . $user['user_id'] . "'><button>Edit</button></a></td>";
                echo '<td>
                        <form method="post">
                            <input type="hidden" name="delete_user" value="' . $user['user_id'] . '">
                            <button type="submit" onclick="return confirm(\'Are you sure?\')">Delete</button>
                        </form>
                    </td>';
                echo "</tr>";
            }
            return true;
        }
    }
}
