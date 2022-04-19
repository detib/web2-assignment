<?php 
    require 'database.php';
    if(!isset($_GET['email'])) {
        header('Location: ../index.php');
        die();
    }
    $email = $_GET['email'];
    $sql = "SELECT email FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    $result = mysqli_fetch_assoc($result);

    echo $result ? true : false;
?>