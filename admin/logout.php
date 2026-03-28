<?php 
 // Delete cookies
    setcookie('remember_token', '', time() - 3600, '/');

    session_start();

    session_unset();

    session_destroy();

    header('location: login.php');
exit;