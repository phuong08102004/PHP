<?php
    session_start();
    ob_start();  

    include('inc/database.php');
    
    _header('Login Page');
    navbar();
    login();

    _footer();

    ob_end_flush(); 
?>
