<?php
    try {
        require_once "./phpappfolder/includes/db_connect.php";
        $query = "SELECT event_date, event_name, event_venue FROM event;";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $pdo = null;
        $stmt = null;
        // Function to categorize events
        function categorizeEvent($eventDate) {
            $today = date("Y-m-d");
            return strtotime($eventDate) >= strtotime($today) ? 'upcoming' : 'past';
        }

    } catch (PDOException $th) {
        die("Query failed: " . $th->getMessage());
    }
$title = " Cryptoshow events";
$css_file = "./css-files/dashboardStyle.css";
$css_file2 = "./css-files/x.css";
include_once "./phpappfolder/includes/header.php";

?>

<script>
            // JavaScript function to filter events
            function filterEvents(type) {
                var events = document.querySelectorAll('.event');
                events.forEach(function(event) {
                    if (type === 'all' || event.classList.contains(type)) {
                        event.style.display = '';
                    } else {
                        event.style.display = 'none';
                    }
                });
            }
</script>
<div class="container">
            <div class="sidebar">
                <div class="filter" onclick="filterEvents('all')">All Events</div>
                <div class="filter" onclick="filterEvents('upcoming')">Upcoming Events</div>
                <div class="filter" onclick="filterEvents('past')">Past Events</div>
            </div>
            <ul class="event-list">
    <?php foreach ($results as $row): ?>
        <?php $eventCategory = categorizeEvent($row["event_date"]); ?>
        <li class="event <?php echo $eventCategory; ?>">
            <div class="event-date"><?php echo htmlspecialchars($row["event_date"]); ?></div>
            <div class="event-title"><?php echo htmlspecialchars($row["event_name"]); ?></div>
            <div class="event-location"><?php echo htmlspecialchars($row["event_venue"]); ?></div>
            <button class="book-button">Book Now</button>
            <br>
            <form action="popup.php" method="post">
                <input type="hidden" name="event_date" value="<?php echo htmlspecialchars($row["event_date"]); ?>">
                <input type="hidden" name="event_name" value="<?php echo htmlspecialchars($row["event_name"]); ?>">
                <input type="hidden" name="event_venue" value="<?php echo htmlspecialchars($row["event_venue"]); ?>">
                <input type="submit" name="submit_button_" value="For more information click here">
            </form>
        </li>
        
    <?php endforeach; ?>
</ul>




    <footer>
        <p>&copy; 2024 CryptoShow. All rights reserved.</p>
    </footer>

    </body>
</html>
