<?php
    /*
    *   PDO Database Class
    */
namespace App\Lib;

require dirname(__dir__) . '/config/config.php';

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher as Dispatcher;
use Illuminate\Container\Container as Container;

class Database
{
    // database connection params
    private $db_host = __DBHOST__;
    private $db_user = __DBUSER__;
    private $db_pass = __DBPASS__;
    private $db_name = __DBNAME__;
    private $db_driver = __DBDRIVER__;

    public $capsule;

    public function __construct()
    {
        $this->capsule = new Capsule;
        $this->capsule->addConnection([
            "driver"    => $this->db_driver,
            "host"      => $this->db_host,
            "database"  => $this->db_name,
            "username"  => $this->db_user,
            "password"  => $this->db_pass,
            "charset"   => "utf8",
            "collation" => "utf8_general_ci",
            "prefix"    => ""
        ]);

        $this->capsule->setEventDispatcher(new Dispatcher(new Container));
        $this->capsule->setAsGlobal();
        $this->capsule->bootEloquent();
    }
}