<?php

/**
 * 
 * This is the script that adds comment,
 * we require the database connection,
 * and we require the session variables to not allow a guest to comment.
 * 
 * 
 */

require 'database.php';
require 'session.php';

if(!$user || !isset($_POST['submit'])) { // check if not a user or no post has been submitted
    header('Location: index.php'); // redirect to the index page
    die(); // die to stop the script
}

$commentUser = $_POST['username']; // store the username in a variable
$comment = mysqli_real_escape_string($conn, $_POST['comment']); // store the comment in a variable // THIS IS THE CHANGED LINE
$post_id = $_POST['id']; // store the post id in a variable

$query = "INSERT INTO 
    comments (user, body, post_id) 
    VALUES ('$commentUser', '$comment', '$post_id')"; // query insert the comment into the database

$result = mysqli_query($conn, $query); // execute the query
header('Location: ../single-post.php?id=' . $post_id); 
// redirect to the single post page with the post id

?>