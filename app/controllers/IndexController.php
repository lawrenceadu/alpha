<?php
    namespace App\Controllers;

    use App\Controllers\Base as Base;
    use Klein\Request;

    class Index extends Base
    {
        public function __construct()
        {
            parent::__construct();        
        }

        public function index(Request $request)
        {
            $this->view("app/index");
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