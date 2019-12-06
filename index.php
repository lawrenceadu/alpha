<?php
    // hide all errors from frontend
    error_reporting(0);
    ini_set('display_errors', 0);
    
    // start session
    session_start();

    // require the bootstrap file
    require_once __DIR__."/app/bootstrap.php";