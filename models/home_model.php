<?php

namespace TodoList\Models;

use TodoList\Libs\Model;
use \PDO;

/**
 * Class Home_Model - Responsible for items CRUD
 * @package TodoList\Models
 */
class Home_Model extends Model {

    /**
     * Return items with or without pagination
     * @return array|false
     */
    public function getItems( $offset = 0, $limit = 0 ) {

        $limitSql = '';

        if ($offset == 0 && $limit > 0) {
            $limitSql = " LIMIT $limit ";
        } else if ($offset > 0 && $limit > 0) {
            $limitSql = " LIMIT $offset, $limit ";
        }

        try {
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conn = $this->db->prepare(
                'SELECT item_id, title, description, active, create_date
                        FROM items
                        WHERE user_id = ' . $_SESSION['user_id']
                        . $limitSql
            );

            $conn->execute();

            // set the resulting array to associative
            $conn->setFetchMode(PDO::FETCH_ASSOC);

            return $conn->fetchAll();

        }
        catch(PDOException $e) {
            return false;
        }

    }

    /**
     * Count items
     * @return int
     */
    public function countItems() {

        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = 'SELECT COUNT(*) AS num
                FROM items
                WHERE user_id = ' . $_SESSION['user_id'];
        $result = $this->db->query($sql);
        list($num) = $result->fetch();

        return (int)$num;

    }

    /**
     * Add new item
     * @param string $title Note title
     * @param string $text Note description
     * @return bool
     */
    public function addItem($title, $text) {

        $active = 1;
        $title = filter_var($title, FILTER_SANITIZE_STRING);
        $text = filter_var($text, FILTER_SANITIZE_STRING);
        $user_id = filter_var($_SESSION['user_id'], FILTER_SANITIZE_NUMBER_INT);

        try {
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conn = $this->db->prepare("INSERT INTO items (title, description, active, user_id) VALUES (:title, :description, :active, :user_id)");
            $conn->bindParam(":title", $title, PDO::PARAM_STR);
            $conn->bindParam(":description", $text, PDO::PARAM_STR);
            $conn->bindParam(":active", $active, PDO::PARAM_INT);
            $conn->bindParam(":user_id",$user_id, PDO::PARAM_INT);
            return $conn->execute();
        }
        catch(PDOException $e) {
            return false;
        }

    }

    /**
     * Mark item as incative
     * @param int $item_id Id of the item to deactivate
     * @return bool
     */
    public function deactivate($item_id) {

        $item_id = filter_var($item_id, FILTER_SANITIZE_NUMBER_INT);

        try {
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE items SET active=0 WHERE item_id=$item_id";
            $conn = $this->db->prepare($sql);
            return $conn->execute();
        }
        catch(PDOException $e) {
            return false;
        }

    }

    /**
     * Delete item
     * @param int $item_id Id of the item to delete
     * @return bool
     */
    public function destroy($item_id) {

        $item_id = filter_var($item_id, FILTER_SANITIZE_NUMBER_INT);

        try {
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "DELETE FROM items WHERE item_id=$item_id";
            $conn = $this->db->prepare($sql);
            return $conn->execute();
        }
        catch(PDOException $e) {
            return false;
        }

    }
}