<?php

    /**
     * 
     * This is one of the important scripts in the app.
     * It is responsible for storing the user data into the session.
     * it runs a session_start() function and then it checks if $_SESSION['user'] is set.
     *   if it is not set then it sets the $_SESSION['user'] to NULL.
     *     this is done because if the user logs in to the page successfully, the $_SESSION['user'] will be set to the user data (This happens in the login page). 
     *       if the $_SESSION['user'] is set, then we destructure the user data and assign it to the variables.
     *         In the $role variable we use the ternary operator to check if the user is an admin or a regular user, in the database the users are stored as 0 and the admin as 1.
     *          When the value of the variable is 0 then it will be falsey and assign user to the variable, if it is 1 then it will be truthy and assign admin to the variable.
     * 
     * 
     * We can later use these variables in the script to display different data to those with permissions.   
     * 
     */

    session_start();
    if ( isset( $_SESSION['user'] ) ) {
        $user = $_SESSION['user'];
        $name = $user['name'];
        $surname = $user['surname'];
        $email = $user['email'];
        $username = $user['username'];
        $password = $user['password'];
        $role = $user['role'] ? 'admin' : 'user';
        $picture = $user['picture'];
    } else {
        $user = NULL;
    }
?>