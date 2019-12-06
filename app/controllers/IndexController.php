<?php
    namespace App\Controllers;

    use App\Controllers\Base as Base;
    use Psr\Http\Message\ServerRequestInterface as Request;

    class Index extends Base
    {
        public function __construct()
        {
            parent::__construct();        
        }

        public function index(Request $request)
        {
           return $this->view("app/index");
        }
    }