<?php
$title = "Admin Page";
$css_file = "./css-files/adminStyle.css";
$css_filee = "./css-files/header.css";
include_once "header.php";
require_once "validateAdmin.php";
include "db_connect.php";
?>
<?php if(isset($_SESSION["message"])) { ?>
    <h5><?= $_SESSION['message'] ?></h5> <?php
    unset($_SESSION["message"]);
} ?>
<div class="container">
    <div class="tabs">
        <button class="tabBtn active">Users</button>
        <button class="tabBtn">Events</button>
        <button class="tabBtn">Devices</button>
        <div class="line"></div>
    </div>
    <div class="contentBox">
        <div class="content active">
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
                    <th colspan="2">Edit</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $query = "SELECT * FROM registered_user";
                $stmt = $pdo->prepare($query);
                $stmt->execute();


                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if($result) {
                    foreach($result as $row) {
                        ?>
                        <tr>
                            <td><?php if($row['is_admin']){echo "Yes";}else{echo "No";}?></td>
                            <td><?= $row['user_id']?></td>
                            <td><?= $row['user_nickname']?></td>
                            <td><?= $row['user_name']?></td>
                            <td><?= $row['user_email']?></td>
                            <td><?= $row['user_device_count']?></td>
                            <td><?= $row['user_registered_timestamp']?></td>
                            <td><a href="userEdit.php?id=<?= $row['user_id']; ?>"><button type= "submit">Edit</button></a></td>
                            <td>
                            <form action="./php-files/userEditProcess.php" method="post">
                            <button type="delete" name="delete" value="<?=$row['user_id']?>" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                            
                        </tr>
                        <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="6">No Record</td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
        </div>
        <div class="content">
            <h2>Events</h2>
            <div>
                <a href="./addEvent.php"><button class= "addEventBtn">Add Event</button></a>
            </div>
            <table>
                <thead>
                <tr>
                    <th>Event ID</th>
                    <th>Event Name</th>
                    <th>Event Description</th>
                    <th>Event Date</th>
                    <th>Event Venue</th>
                    <th>Published</th>
                    <th colspan="3">Edit</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $query = "SELECT * FROM event";
                $stmt = $pdo->prepare($query);
                $stmt->execute();

                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if($result) {
                    foreach($result as $row) {
                        ?>
                        <tr>
                            <td><?= $row['event_id']?></td>
                            <td><?= $row['event_name']?></td>
                            <td><?= $row['event_description']?></td>
                            <td><?= $row['event_date']?></td>
                            <td><?= $row['event_venue']?></td>
                            <td><?php if($row['is_published']){echo "Yes";}else{echo "No";}?></td>
                            <td><a href="eventEdit.php?eventid=<?= $row['event_id']; ?>"><button type="submit">Edit</button></a></td>
                            <td>
                                <form action="./php-files/eventEditProcess.php" method="post">
                                    <button type="delete" name="delete" value="<?=$row['event_id']?>" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                            <td>
                                <form action="./php-files/eventEditProcess.php" method="post">
                                    <button type="submit" name="publish" value="<?=$row['event_id']?>" onclick="return confirm('Are you sure?')">Publish</button>
                                </form>
                            </td>

                        </tr>
                        <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="4">No Record</td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
        </div>
        <div class="content">
            <h2>Devices</h2>
            <table>
                <thead>
                <tr>
                    <th>User ID</th>
                    <th>Nickname</th>
                    <th>Fullname</th>
                    <th>Email</th>
                    <th>Device count</th>
                    <th>Registered</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $query = "SELECT * FROM registered_user";
                $stmt = $pdo->prepare($query);
                $stmt->execute();

                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if($result) {
                    foreach($result as $row) {
                        ?>
                        <tr>
                            <td><?= $row['user_id']?></td>
                            <td><?= $row['user_nickname']?></td>
                            <td><?= $row['user_name']?></td>
                            <td><?= $row['user_email']?></td>
                            <td><?= $row['user_device_count']?></td>
                            <td><?= $row['user_registered_timestamp']?></td>
                        </tr>
                        <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="6">No Record</td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
        </div>

    </div>
</div>

<div>

</div>


<?php
    include_once "footer.php";
    ?>

</body>

</html>