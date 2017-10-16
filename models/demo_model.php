<?php

namespace TodoList\Models;

use TodoList\Libs\Model;
use \PDO;

/**
 * Class Demo_Model - Responsible for creating database required tables
 * @package TodoList\Models
 */
class Demo_Model extends Model {

    /**
     * Create required tables or refresh tables
     * @return bool
     */
    public function refreashTables() {

        try {

            $userPassword = '$2y$10$m6wkXCaIAVzf4eGABRV/NOi/ZXGf2DXsqIU/dC8MNZKsviYjXnZcu';

            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conn = $this->db->prepare(
                "DROP TABLE IF EXISTS items;
                  CREATE TABLE items (
                  item_id int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                  title varchar(256) NOT NULL,
                  description mediumtext NOT NULL,
                  active tinyint(1) NOT NULL,
                  create_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                  user_id tinyint(3) NOT NULL,
                  PRIMARY KEY ( item_id )
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
                
                DROP TABLE IF EXISTS users;
                  CREATE TABLE users (
                  user_id int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                  login varchar(20) NOT NULL,
                  password varchar(255) NOT NULL,
                  email varchar(128) NOT NULL,
                  registration_date bigint(10) NOT NULL,
                  PRIMARY KEY ( user_id )
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
            );

            return $conn->execute();
        }
        catch(PDOException $e) {
            return false;
        }

    }

}