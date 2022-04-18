<?php 
    require 'database.php';
    if(!isset($_GET)) {
        header('Location: index.php');
        die();
    }
    $username = $_GET['username'];
    $sql = "SELECT username FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);
    $result = mysqli_fetch_assoc($result);

    echo $result ? true : false;
?>