<?php
    define("DB_HOST", "remotemysql.com");
    define("DB_USER", "cjYy74pr42");
    define("DB_PASS", "wevo1PivUY");
    define("DB_NAME", "cjYy74pr42");
    
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if(!$conn){
        echo ("Connection failed: ".mysqli_connect_error());
    }
?>