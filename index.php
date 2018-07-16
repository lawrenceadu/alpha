<?php 
	session_start();
    $_GET["url"] = $_SERVER['REQUEST_URI'];

    // require the bootstrap file
    require_once __DIR__."/app/bootstrap.php";

    // init core lib
    $core = new Core;
?>