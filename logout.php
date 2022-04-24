<?php 


/**
 * 
 * This is the logout script, it will destroy the session and redirect the user to the index page, 
 *   and since we have the user data stored in the session, that will mean that the user will be logged out
 * 
 * 
 */
    session_start();
    session_destroy();
    header('Location: index.php');

?>