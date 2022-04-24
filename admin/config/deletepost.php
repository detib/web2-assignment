<?php 

/**
 * 
 * this script is for the deletion of the blog posts, it is highly similar to the approve user, delete user scripts,
 *   the difference is that this script executes multiple, different queries
 * it is used by the posts.php page, (posts.php has tags that are used to call this script with the necessary variables 
 *   (<a> tags that are formatted in the posts.php?post=<post_id> format))
 * 
 * 
 * we require the config files that we use in this page
 * we require the database.php file so that we can use the database connection
 * we require the session.php file so that we can use the session variables,
 *   that are also used in the admin.php file, that is why we call the session.php file before the admin.php file
 * 
 * and we require the admin.php file so that we cannot let a user here if they are not an admin
 * 
 */
require '../../config/database.php';
require '../../config/session.php';
require '../admin.php';

// we check if the $_GET['post'] is not set, the script is useless without that variable so we redirect to the index.php file
if ( !isset( $_GET['post'] ) ) {
  header( 'Location: ../../index.php' );
}

// we sanitize the $_GET['post'] variable so that it is safe to use in the query, and store it in the $post variable
$post = mysqli_real_escape_string($conn, $_GET['post']);

// write the query that deletes the post from the posts table
$query = "DELETE FROM posts WHERE id = '$post'";

// we execute the query, inside an if statement with an exlamation mark, so that if the query fails we can see the error with the mysqli_error function
if ( !mysqli_query( $conn, $query ) ) {
  echo 'Error: ' . mysqli_error( $conn );
} 

// write the query that deletes the post from the comments table, because when a post is deleted, all the comments that are related to that post are also deleted
$query = "DELETE FROM comments WHERE post_id = '$post'";

// we execute the query, inside an if statement with an exlamation mark, so that if the query fails we can see the error with the mysqli_error function
if ( !mysqli_query( $conn, $query ) ) {
  echo 'Error: ' . mysqli_error( $conn );
}

// lastly we redirect the user to the posts.php page
header( "Location: ../posts.php" );

?>