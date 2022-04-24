<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- This meta tag redirects the user to the index.php file after 1 second -->
    <meta http-equiv="refresh" content="1;url=../index.php" />
    <!--  -->
    <title>Newsletter</title>
</head>
<body>

<?php 
    /**
     * 
     * This is the page that is used to register the subscribers to the newsletter
     * 
     * It checks for a post request and if it is there, it checks if the email is valid and if it is not already registered
     * 
     * The newsletter table in the database has the email column which is defined as a unique column, so if the email is already registered,
     *   the mysqli_query function will return false and the email will not be registered.
     * 
     * Then we echo the necessay messages to the user.
     * 
     * Then after that the page redirects to the index page through the meta tag above.
     * 
     */
    require 'database.php';

    if(isset($_POST['email'])) {
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $query = "INSERT INTO newsletter (email) VALUES ('$email')";
        $result = mysqli_query($conn, $query);
        if($result) {
            echo "<script>alert('You have been successfully subscribed to our newsletter.')</script>";
        } else {
            echo "<script>alert('You are already subscribed to our newsletter.')</script>";
        }
    }

?>
</body>
</html>