<?php
    session_start();
    if ( isset( $_SESSION['user'] ) ) {
        $user = $_SESSION['user'];
        $name = $user['name'];
        $surname = $user['surname'];
        $email = $user['email'];
        $username = $user['username'];
        $password = $user['password'];
        $role = $user['role'] ? 'admin' : 'user';
    } else {
        $user = null;
    }
?>