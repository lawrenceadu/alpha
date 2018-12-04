<?php 
    namespace App\Routes;

    use App\Controllers as Controller;

    class Api {
        public function __construct()
        {
            
        }

        public static function get($url, $path) {
            // call setter
            $currentController = new Controller\App();
            $currentMethod     = index;
            $params            = [];
            
            $start = $url[0];
            unset($url[0]);

            switch ($start) {
                default:
                    list($currentController, $currentMethod, $url) = [$currentController, $currentMethod, $url];
                    break;                
            }
            
            $params = $url ? array_values($url) : [];

            call_user_func_array([$currentController, $currentMethod], $params);
        }

        public static function post($url, $path) {
            $currentController = new Controller\App();
            $currentMethod     = index;
            $params            = [];

            $start = $url[0];
            unset($url[0]);

            switch ($start) {
                default:
                    list($currentController, $currentMethod, $url) = [$currentController, $currentMethod, $url];
                    break;
            }

            $params = $url ? array_values($url) : [];
            call_user_func_array([$currentController, $currentMethod], $params);
        }

        public static function put($url, $path) {

        }

        public static function delete($url, $path) {

        }
    }
?>