<?php

namespace TodoList\Libs;

/**
 * Class Database
 * @package TodoList\Libs
 */
class Database extends \PDO {

    /**
     * Database constructor. Set db connection
     */
    public function __construct() {
        parent::__construct(getenv('DRIVER').':host='.getenv('HOST').';dbname='.getenv('DATABASE') ,getenv('USERNAME'), getenv('PASSWORD'));
    }
    
}