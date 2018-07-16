<?php 
    /*
    * App Core Class
    * Creates URL & loads core controller
    * URL FORMAT  /controller/method/params
    */

    class Core {
        protected $currentController   =   'App';
        protected $currentMethod       =   'index';
        protected $params              =   [];

        public function __construct(){
            $url = $this->getUrl();

            $url[0] = $this->formatURL($url[0]);

            // Look in controllers for controller
            if(file_exists(dirname(__dir__)."/controllers/" . ucwords($url[0]) . "Controller.php")){
                // if controller exists, set as controller
                $this->currentController = ucwords($url[0]);
                // unset 0 index
                unset($url[0]);
            }
            

            // Require the controller
            require_once dirname(__dir__)."/controllers/" . $this->currentController . "Controller.php";

            // instantiate controller class
            $this->currentController = new $this->currentController;

            // check for the controller method to load

                if (isset($url[1])){
                    // check if method exist
                    if(method_exists($this->currentController, $url[1])){
                        $this->currentMethod = $url[1];
                        // unset 1 url index
                        unset($url[1]);
                    }
                }
            

            // get params
            $this->params = $url ? array_values($url) : [];

            // call a callback with array of params
            call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
        }

        public function getUrl(){
            if (isset($_GET["url"])){
                $url = trim($_GET["url"], "/");
                $url = filter_var($url, FILTER_SANITIZE_URL);
                $url = explode( "/", $url);

                return $url;
            }
        }

        private function formatURL($url){
            return str_replace(" ", "", ucwords(str_replace("-", " ", $url)));
        }
    }