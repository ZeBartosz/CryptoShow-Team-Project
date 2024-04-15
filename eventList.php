<?php
include_once "db_connect.php";
    try {
        $query = "SELECT * FROM event;";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $pdo = null;
        $stmt = null;
    } catch (PDOException $th) {
        die("Query failed: " . $th->getMessage());
    }
$title = " Cryptoshow events";
$css_file = "./css-files/header.css";
$css_filee = "./css-files/x.css";
include_once "header.php";
include_once "eventController.php";
include_once "userController.php";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST["book"])) {
        $event_id = $_POST["event_id"];
        $user_id = $_SESSION["user_id"];
        $controller = new EventController();
        $controller->setUserForeignId($user_id);
        $controller->setEventForeignId($event_id);
        $controller->bookEvent($user_id, $event_id);
    }
}
?>
<main>
<div class="container">
    <div class="event-list">
        <?php if(empty($results)) { ?>
            <div class="event-location">Currently there are no events</div>
        <?php } ?>
        <?php foreach ($results as $row) { ?>
            <?php if($row["is_published"]) { ?>
                <li class="event">
                <div class="event-date"><?php echo htmlspecialchars($row["event_date"]); ?></div>
                <div class="event-title"><?php echo htmlspecialchars($row["event_name"]); ?></div>
                <div class="event-location"><?php echo htmlspecialchars($row["event_venue"]); ?></div>
                <div class="event-location"><?php if(isset($_SESSION["user_id"]) && $row["event_id"]) {
                    $isAttending = new UserController();
                    $isAttending = $isAttending->isAttending($_SESSION["user_id"], $row["event_id"]);
                    if($isAttending) {
                        echo "You are attending";
                    } else {
                        echo "You are Not attending";
                    }
                }?>
                </div>
                <?php
                if(isset($_SESSION["user_id"]) && $row["event_id"]){
                    $isAttending = new UserController();
                    $isAttending = $isAttending->isAttending($_SESSION["user_id"], $row["event_id"]);
                    if(!$isAttending) { ?>
                        <form method="post">
                            <input name="event_id" type="hidden" value='<?= $row["event_id"] ?>'>
                            <button name="book" type="book" class="book-button">Book Now</button>
                        </form>
                    <?php } else {
                    } ?>
                <?php } ?>
            <?php } ?>
            <?php if($row["is_published"]) { ?>
                <form action="popup.php" method="post">
                    <input type="hidden" name="event_date" value="<?php echo htmlspecialchars($row["event_date"]); ?>">
                    <input type="hidden" name="event_name" value="<?php echo htmlspecialchars($row["event_name"]); ?>">
                    <input type="hidden" name="event_venue" value="<?php echo htmlspecialchars($row["event_venue"]); ?>">
                    <input type="hidden" name="event_description" value="<?php echo htmlspecialchars($row["event_description"]); ?>">
                    <input type="hidden" name="event_id" value="<?php echo htmlspecialchars($row["event_id"]); ?>">
                    <input type="submit" name="submit_button" class="info-button" value="For more information click here"></form>
            <?php } ?>
            </li>
        <?php } ?>
    </div>
    </ul>
</div>
</main>
<?php
    include_once "footer.php";
    ?>
</body>
</html>

