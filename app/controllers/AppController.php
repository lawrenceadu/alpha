<?php 
    class App extends Base
    {
        public function __construct(){
            // $this->appModel = $this->model('Example');
        }

        public function index(){
            // you can pass data here
            // $data["title"] = "Hello world";
            // $data["img"] = "path/to/img";
            // $data["keywords"] = "Hello world";
            // $data["description"] = "Hello world";
            $data = null;

            $this->view("app/index.html", $data);   
        }
    }
    
?>