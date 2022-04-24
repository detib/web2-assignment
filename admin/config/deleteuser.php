<?php 

/**
 * 
 * this script is for deleting a user, it is highly similar to the approve user script, the difference is the query that is executed
 * it is used by the users.php page, (users.php has tags that are used to call this script with the necessary variables)
 * 
 * 
 * we require the config files that we use in this page
 * we require the database.php file so that we can use the database connection
 * we require the session.php file so that we can use the session variables,
 *   that are also used in the admin.php file, that is why we call the session.php file before the admin.php file
 * 
 * and we require the admin.php file so that we cannot let a user here if they are not an admin
 * 
 * 
 */
require '../../config/database.php';
require '../../config/session.php';
require '../admin.php';


// we check if the $_GET['user'] is not set, the script is useless without that variable so we redirect to the users.php file
if ( !isset( $_GET['user'] ) ) {
  header( 'Location: ../users.php' );
}

// we sanitize the $_GET['user'] variable so that it is safe to use in the query, and store it in the $user variable
$user = mysqli_real_escape_string($conn, $_GET['user']);

// write the query that changes the state of the user account to 1, meaning that the user is approved
$query = "DELETE FROM users WHERE username = '$user'";

// we execute the query, inside an if statement with an exlamation mark, so that if the query fails we can see the error with the mysqli_error function
if ( !mysqli_query( $conn, $query ) ) {
  echo 'Error: ' . mysqli_error( $conn );
}

// lastly we redirect the user to the users.php page
header( "Location: ../users.php" );

?>