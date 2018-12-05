<?php 
    namespace App\Routes;

    use App\Controllers as Controller;
    use \Klein\Klein;

    class Web {
        public function __construct()
        {
            $this->klein = new Klein();
        }

        public function arr($controller, $method, $params = [])
        {
            return \call_user_func_array([$controller, $method], $params);
        }

        public function request() {
            $this->klein->respond("GET", "/?", function($request, $response) {
                $this->arr(new Controller\App(), index);
            });

            $this->klein->with('/hello-world', function() use ($klein) {
                return "hello world";
            });

            $this->klein->dispatch();
        }
    }
?>