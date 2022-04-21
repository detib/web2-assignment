<?php

require 'database.php';
require 'session.php';

if(!$user || !isset($_POST['submit'])) {
    header('Location: index.php');
    die();
}

$commentUser = $_POST['username'];
$comment = $_POST['comment'];
$post_id = $_POST['id'];

$query = "INSERT INTO 
    comments (user, body, post_id) 
    VALUES ('$commentUser', '$comment', '$post_id')";

$result = mysqli_query($conn, $query);
header('Location: ../single-post.php?id=' . $post_id);

?>