<?php
    /*
    *
    *
    * this script is used by the signup form to
    *   check the availability of the email,
    *
    * it is called via ajax and returns a boolean
    *   -true if the email is already in use
    *   -false if it is not in use
    *
    *
    */

    // include the database connection file
    require 'database.php';

    // check if the email is sent with GET (in ajax we send the data with a get)
    // if it is not sent, redirect the user to the index page,
    // this is made so that no user can access this page
    if ( !isset( $_GET['email'] ) ) {
    header( 'Location: ../index.php' );
    die();
    }

    // get the email from the GET superglobal,
    // and clean the data to prevent sql injection attacks
    $email = mysqli_real_escape_string( $conn, $_GET['email'] );
    // write the query
    $sql = "SELECT email FROM users WHERE email = '$email'";
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