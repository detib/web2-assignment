<?php
    /*
     *
     *
     * this script is used by the signup form to
     *   check the availability of the username,
     *
     * it is called via ajax and returns a boolean
     *   -true if the username is not available
     *   -false if it is available
     *
     * 
     */

    // include the database connection file
    require 'database.php';

    // check if the username is sent with GET (in ajax we send the data with a get)
    // if it is not sent, redirect the user to the index page,
    // this is made so that no user can access this page
    if ( !isset( $_GET['username'] ) ) {
    header( 'Location: ../index.php' );
    die();
    }

    // get the username from the GET superglobal, 
    // and clean the data to prevent sql injection attacks
    $username = mysqli_real_escape_string($conn, $_GET['username']);
    // write the query
    $sql = "SELECT username FROM users WHERE username = '$username'";
    // query the result
    $result = mysqli_query( $conn, $sql );
    // fetch the result in an associative array
    $result = mysqli_fetch_assoc( $result );


    /*
     * 
     * check the result with the ternary operator, if it exists,
     * return true, otherwise false
     *  
     */
    echo $result ? true : false;
?>