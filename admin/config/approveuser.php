<?php

require '../../config/database.php';
require '../../config/session.php';
require '../admin.php';

if ( !isset( $_GET['user'] ) ) {
  header( 'Location: ../users.php' );
}

$user = mysqli_real_escape_string($conn, $_GET['user']);

$query = "UPDATE users SET is_active = 1 WHERE username = '$user'";
if ( !mysqli_query( $conn, $query ) ) {
  echo 'Error: ' . mysqli_error( $conn );
}
header( "Location: ../users.php" );

?>