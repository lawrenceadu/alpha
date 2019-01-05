<?php 
    namespace App\Routes;

    use App\Controllers as Controller;
    use \Klein\Klein;

    class Api {
        public function __construct()
        {
            $this->klein = new Klein();
        }

        public function arr($controller, $method, $params = [])
        {
            return \call_user_func_array([$controller, $method], $params);
        }

        public function request() {
            
        }
    }
?>