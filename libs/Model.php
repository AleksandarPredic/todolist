<?php

namespace TodoList\Libs;

/**
 * Class Model
 * @package TodoList\Libs
 */
class Model {

    /**
     * Model constructor.
     */
    public function __construct() {
        $this->db = new Database();
        $this->db->exec(
            "SET character_set_connection = 'utf8',
             character_set_server = 'utf8',
             character_set_client = 'utf8',
             character_set_database = 'utf8',
             character_set_results = 'utf8'"
        );
    }

    /**
     * Verify that required tables exist
     * @return bool
     */
    public function verifyTables() {

        try {
            $result = $this->db->query("SELECT * FROM items");
            if (false === $result) {
                return false;
            }
        } catch (Exception $e) {
            // We got an exception == table not found
            return false;
        }

        try {
            $result = $this->db->query("SELECT * FROM users");
            if (false === $result) {
                return false;
            }
        } catch (Exception $e) {
            // We got an exception == table not found
            return false;
        }

        return true;

    }
    
}