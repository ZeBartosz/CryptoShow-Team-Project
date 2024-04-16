<?php

/**
 * Redirects the user to the home page if they are already logged in.
 * 
 * This function checks if the session contains a 'user_id' key, indicating that
 * the user is currently logged in. If they are logged in, it redirects them to
 * the home page and prevents further script execution.
 */
function isLoggedIn() {
    if (isset($_SESSION['user_id'])) {
        header('Location: index.php');
        exit();
    }
}

/**
 * Redirects the user to the home page if they are not logged in.
 * 
 * This function checks if the session does not contain a 'user_id' key, indicating that
 * the user is not logged in. If they are not logged in, it redirects them to the
 * home page and prevents further script execution.
 */
function isNotLoggedIn() {
    if (!isset($_SESSION['user_id'])) {
        header('Location: index.php');
        exit();
    }
}
