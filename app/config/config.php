<?php 
    // get config.ini
    $config = parse_ini_file(__dir__.'/config.ini');

    if (!isset($_SERVER["SERVER_PORT"]))
        $_SERVER["SERVER_PORT"] = 80;

    if (!isset($_SERVER['HTTP_HOST']))
        $_SERVER["HTTP_HOST"] = NULL;
    
    // check protocol
    $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    
    // if production environment, enable strict ssl
    switch ($config["environment"]) {
        case 'production':
            // check the protocol
            if ($protocol == 'http://'):
                // build redirect url
                $url = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                header("Location: {$url}");
            endif; 
            break;
    }

    // define db params
    define("__DBHOST__", $config['host']);
    define("__DBUSER__", $config['username']);
    define("__DBPASS__", $config['password']);
    define("__DBNAME__", $config['database']);
    define("__DBDRIVER__", $config['driver']);

    // define configs
    define('__PROTOCOL__',  $protocol);
    define('__ROOT__',      dirname(dirname(dirname(__FILE__))));
    define('__APPROOT__',   dirname(dirname(__FILE__)));
    define('__URLROOT__',   "{$protocol}{$_SERVER['HTTP_HOST']}");
    define('__SITENAME__',  "The Alpha Framework");
    define('__AUTHOR__',    "Adu Lawrence Kweku");
?>