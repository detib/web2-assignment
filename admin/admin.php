<?php

/**
 * 
 * this script is for the admin dashboard, and it checks if the $user variable is set, meaning a user is already logged in
 * and the $role of the user, if it is admin it will allow the user to see the dashboard, if it is not admin it will redirect them to the index page
 * 
 * this script is useful beacuse we call it with the require function in every page we do not want any user without permissions to see or access the dashboard
 * 
 */

if ( !$user || $role != 'admin') {
  header( 'Location: ../index.php' );
  die();
}

?>