<?php
    define("DB_HOST", "remotemysql.com");
    define("DB_USER", "xx9tjDv0Fg");
    define("DB_PASS", "MuzHmV4ZdO");
    define("DB_NAME", "xx9tjDv0Fg");
    
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if(!$conn){
        echo ("Connection failed: ".mysqli_connect_error());
    }
?>