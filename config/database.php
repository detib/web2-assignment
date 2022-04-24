<?php
    /**
     * 
     * This is one of the most important scripts in the whole app.
     * It is responsible for connecting to the database.
     * 
     * First we defined as constants the database host, username, password and database name.
     * Then we run the mysqli_connect function to connect to the database.
     *  
     *
     * Then we check if the connection was not successful.
     * If it was not successful, we echo the error message.
     * 
     *  
     */
    define("DB_HOST", "localhost");
    define("DB_USER", "root");
    define("DB_PASS", "");
    define("DB_NAME", "blog");
    
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if(!$conn){
        echo ("Connection failed: ".mysqli_connect_error());
    }
?>