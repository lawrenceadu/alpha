<?php 
    class App extends Base
    {
        public function __construct(){
            // $this->appModel = $this->model('Example');
        }

        public function index(){
            $this->view("app/index.html");   
        }
    }
    
?>