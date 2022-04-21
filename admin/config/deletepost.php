<?php 


require '../../config/database.php';
require '../../config/session.php';
require '../admin.php';

if ( !isset( $_GET['post'] ) ) {
  header( 'Location: ../../index.php' );
}

$post = mysqli_real_escape_string($conn, $_GET['post']);

$query = "DELETE FROM posts WHERE id = '$post'";
if ( !mysqli_query( $conn, $query ) ) {
  echo 'Error: ' . mysqli_error( $conn );
}
header( "Location: ../posts.php" );

?>