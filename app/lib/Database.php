<?php
    /*
    *   PDO Database Class
    */
namespace App\Lib;

use PDO as PDO;
class Database
{
    // database connection params
    private $db_host = __DBHOST__;
    private $db_user = __DBUSER__;
    private $db_pass = __DBPASS__;
    private $db_name = __DBNAME__;

    // database handler
    private $db_h;
    private $stmt;
    private $error;

    public function __construct()
    {
        // set dsn
        $dsn = "mysql:host={$this->db_host};dbname={$this->db_name}";

        $options =  [
                        PDO::ATTR_PERSISTENT => true,
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                    ];

        // create PDO instance
        try {
            $this->db_h = new PDO($dsn, $this->db_user, $this->db_pass, $options);
            $this->db_h->exec("SET time_zone='+0:00';");
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
        }
    }

    // Prepare statement with query
    public function query($sql)
    {
        $this->stmt = $this->db_h->prepare($sql);
    }

    // Bind values
    public function bind($param, $value, $type = null)
    {
        if (is_null($type)) :
            switch (true) {
                case is_int($value);
                    $type = PDO::PARAM_INT;
                break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
                    break;
            }
        endif;

        $this->stmt->bindValue($param, $value, $type);
    }

    // execute prepared statem
    public function execute()
    {
        return $this->stmt->execute();
    }

    // get result set as array of objects
    public function result()
    {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function row()
    {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_OBJ);
    }

    public function rowcount()
    {
        return $this->stmt->rowCount();
    }

    public function migrate($sql)
    {
        $this->query($sql);
        return $this->execute();
    }
}
