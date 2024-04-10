<?php
if(isset($_SESSION["is_admin"]) && $_SESSION["is_admin"]) {
} else {
    header("location: index.php");
}