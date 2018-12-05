<?php
    /*
    * App Core Class
    * Creates URL & loads core controller
    * URL FORMAT  /controller/method/params
    */

namespace App\Lib;

use RecursiveDirectoryIterator as RecursiveDirectory;
use RecursiveIteratorIterator as RecursiveIterator;
use RegexIterator as Regex;
use RecursiveRegexIterator as RecursiveRegex;
use App\Routes as Routes;
class Core
{
    public function __construct()
    {
        // assign get url to url variable
        list($url, $path)  = $this->getUrl();

        // Recursive Directory Iterator to get all Controller files
        $Directory = new RecursiveDirectory(dirname(__DIR__) . '/controllers');
        $Iterator  = new RecursiveIterator($Directory);
        $Regex     = new Regex($Iterator, '/^.+\.php$/i', RecursiveRegex::GET_MATCH);

        if($url[0] == "api")
        $Routes = new Routes\Api($url, $path);
        else    
        $Routes = new Routes\Web($url, $path);

        // Get all the helpers
        foreach (glob(dirname(__dir__) . '/helpers/*.php') as $key => $helpers)
            require_once $helpers;

        // Look in controllers for controller
        foreach ($Regex as $path_to_file)
            require_once $path_to_file[0];

        $Routes->request();
    }

    public function getUrl()
    {
        if (isset($_GET["url"])) {
            $url = trim($_GET["url"], "/");

            // get position of ?
            $position = strpos($url, '?');

            if(!empty($position))
                $path = substr($url, 0, strpos($url, '?'));
            else
                $path = $url;
            
            
            $url = filter_var($path, FILTER_SANITIZE_URL);
            $url = explode("/", $url);

            return [$url, $path];
        }
    }
}
