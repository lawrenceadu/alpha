<?php
    /*
    * App Core Class
    * Creates URL & loads core controller
    * URL FORMAT  /controller/method/params
    */

namespace App\Lib;

use App\Routes as Routes;
class Core
{
    public function __construct()
    {
        // assign get url to url variable
        list($url, $path)  = $this->getUrl();

        if($url[0] == "api"):
            header("Access-Control-Allow-Origin: *");
            $route = new Routes\Api($url, $path);
        else:    
            $route = new Routes\Web($url, $path);
        endif;

        $route->request();
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