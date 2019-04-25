<?php
    namespace App\Controllers;
    use App\Controllers\Base as Base;

    class Index extends Base
    {
        public function __construct()
        {
            parent::__construct();        
        }

        public function index()
        {
            $this->view("app/index.html");
        }

        public function create()
        {

        }

        public function show()
        {

        }

        public function destroy()
        {

        }
    }