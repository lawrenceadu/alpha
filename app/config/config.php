<?php 
    // get config.ini
    $config = parse_ini_file(__dir__.'/config.ini');
    
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

    // minify html
    function minify_output($buffer){
        $search = array(
            '/\>[^\S ]+/s',
            '/[^\S ]+\</s',
            '/(\s)+/s'
        );
        $replace = array(
            '>',
            '<',
            '\\1'
        );
        if (preg_match("/\<html/i", $buffer) == 1 && preg_match("/\<\/html\>/i", $buffer) == 1) {
            $buffer = preg_replace($search, $replace, $buffer);
        }
        return $buffer;
	}
	// run minifier
	ob_start("minify_output");

    // define db params
    // define("__DBHOST__", $config['host']);
    // define("__DBUSER__", $config['username']);
    // define("__DBPASS__", $config['password']);
    // define("__DBNAME__", $config['database']);

    // define configs
    define('__PROTOCOL__',  $protocol);
    define('__ROOT__',      dirname(dirname(dirname(__FILE__))));
    define('__APPROOT__',   dirname(dirname(__FILE__)));
    define('__URLROOT__',   "{$protocol}{$_SERVER['HTTP_HOST']}");
    define('__SITENAME__',  "The Alpha Framework");
    define('__AUTHOR__',    "Adu Lawrence Kweku");
?>