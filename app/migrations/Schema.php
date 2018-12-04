<?php
    $_SERVER["SERVER_PORT"] = 80;
    $_SERVER["HTTP_HOST"] = NULL;

    require_once dirname(__dir__).'/config/config.php';
    require_once dirname(__dir__).'/lib/Database.php';

    $db = new App\Lib\Database();

    $timestamp  =   "`created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                    `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                    ";

    // foreign keys
    function references($foreign_key, $table, $primary_key){
        return "FOREIGN KEY (`{$foreign_key}`) REFERENCES `{$table}`(`{$primary_key}`)";
    }

    $_ = function ( $func ) {
        return $func;
    };

    // $db->migration("CREATE TABLE IF NOT EXISTS `table_name`(
    //                 `id` INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    //                 `other_columns` DATATYPE() NOT NULL,
    //                 {$timestamp}
    // );
    // ");