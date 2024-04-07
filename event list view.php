<?php

    try {
        require_once "phpappfolder/includes/db_connect.php";

$query = "SELECT event_date, event_name, event_venue FROM event;";
$stmt = $pdo->prepare($query);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

$pdo = null;
$stmt = null;

    
    } catch (PDOException $th) {
       die("Query failed: " . $th->getMessage());
 
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Event List View</title>
<link rel="stylesheet" href="./css-files/x.css" defer>
</head>
<header>
    <h1>CryptoShow</h1>
    <nav>
        <ul>
            <li><a href="#">Lorem</a></li>
            <li><a href="#">Quis</a></li>
            <li><a href="#">Fugiat</a></li>
            <li><a href="#">Deleniti</a></li>
            <li><a href="#">Ipsum</a></li>
            <li><a href="profile.html">Profiles</a></li>
        </ul>
    </nav>
    <a href=./login.html>
        <button class="login-button">
            Login
        </button>
    </a>


</header>
<body>
    <div class="container">
        <div class="sidebar">
          <div class="filter" onclick="filterEvents('all')">All Events</div>
          <div class="filter" onclick="filterEvents('upcoming')">Upcoming Events</div>
          <div class="filter" onclick="filterEvents('past')">Past Events</div>
        </div>
        <ul class="event-list">
<?php  foreach ($results as $row) {
echo'
<li class="event">  
<div class="event-date">';echo htmlspecialchars( $row["event_date"]);echo'</div>
    <div class="event-title">';echo htmlspecialchars( $row["event_name"]); echo'</div>
    <div class="event-location">';echo htmlspecialchars( $row["event_venue"]); echo'</div>
    <button class="book-button">Book Now </button>
</li>';}
    ?></ul> 
  
  <!-- Repeat for each event i am going to use php looping the event from the database  -->

</div>
</body>
<footer>
    <p>&copy; 2024 CryptoShow. All rights reserved.</p>
    <a href="#">About Us |</a>
    <a href="#">Contact Us |</a>
    <a href="#">Learn More</a>
    </button>
</footer>

</html>
