<?php
    // hide all errors from frontend
    error_reporting(0);
    ini_set('display_errors', 0);
    
    // start session
    session_start();

    // get request url
    $_GET["url"] = $_SERVER['REQUEST_URI'];

    // require the bootstrap file
    require_once __DIR__."/app/bootstrap.php";

    use App\Lib\Core;
    // init core lib
    new Core();