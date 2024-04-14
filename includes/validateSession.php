<?php

function isLoggedIn() {
    if (isset($_SESSION['user_id'])) {
        header('Location: index.php');
        exit();
    }
}

function isNotLoggedIn() {
    if (!isset($_SESSION['user_id'])) {
        header('Location: index.php');
        exit();
    }
}
