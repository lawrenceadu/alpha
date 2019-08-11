<?php 
    namespace App\Routes;

    use App\Controllers as Controller;
    use \Klein\Klein;

    class Api {
        public function __construct()
        {
            $this->klein = new Klein();
        }

        public function request() {
            $this->klein->respond("GET", "/?", [new \App\Controllers\Index(), 'index']);

            $this->klein->dispatch();
        }
    }
?>