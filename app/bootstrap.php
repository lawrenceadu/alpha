<?php
    // load config
    require_once 'config/config.php';
    require_once 'lib/vendor/autoload.php';
    require_once 'routes/web.php';
    require_once 'routes/api.php';

    // autoload core libraries
    spl_autoload_register(function ($className) {
        $part = explode('\\', $className);
        require 'lib/' . end($part). '.php';
    });
