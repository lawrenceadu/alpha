<?php
    require_once dirname(__DIR__).'/vendor/autoload.php';

    // start env
    \Dotenv\Dotenv::create(dirname(__DIR__))->load();

    require_once 'routes/web.php';
    require_once 'routes/api.php';