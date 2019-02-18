<?php

namespace App\Controllers;

use App\Controllers\Base as Base;

// use App\Helpers\Example;
class Index extends Base
{
    public function __construct()
    {
        // $this->carousel = $this->model('App\Models\ModelName');
        // $this->example_helper = new Example();
    }

    public function index()
    {
        $this->view("app/index.html");
    }
}
