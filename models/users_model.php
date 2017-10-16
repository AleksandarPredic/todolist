<?php

namespace TodoList\Models;

use TodoList\Libs\Model;
use \PDO;

/**
 * Class Users_Model - Responsible for users CRUD
 * @package TodoList\Models
 */
Class Users_Model extends Model{

    /**
     * Add new user to database
     * @param array $user User data as array
     * @return bool
     */
    public function addUser($user) {
        $registrationDate = time();
        $password = $this->passwordHash($user['password']);
        $login = filter_var($user['login'], FILTER_SANITIZE_STRING);
        $email = filter_var($user['email'], FILTER_SANITIZE_STRING);

        try{
            $sql = "SELECT *
                FROM `users`
                WHERE `login` = '{$user['login']}' OR `email` = '{$user['email']}' ";
            $result = $this->db->query($sql);

            if ($result->rowCount() > 0) {
                return false;
            }

            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO users (login, password, email, registration_date) VALUES (:login, :password, :email, :registration_date)";
            $conn = $this->db->prepare($sql);
            $conn->bindParam(':login', $login, PDO::PARAM_STR);
            $conn->bindParam(':password', $password, PDO::PARAM_STR);
            $conn->bindParam(':email', $email, PDO::PARAM_STR);
            $conn->bindParam(':registration_date', $registrationDate);

            return $conn->execute();

        } catch(PDOException $e) {
            return false;
        }


    }

    /**
     * Create user session
     * @param string $login User username
     * @param string $password User password
     * @return bool
     */
    public function loginCheck($login, $password) {

        try {
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "SELECT `user_id`, `login`, `password`, `email`
                FROM `users`
                WHERE `login` = '$login'
                LIMIT 1";

            $conn = $this->db->prepare($sql);
            $conn->execute();

            // set the resulting array to associative
            $conn->setFetchMode(PDO::FETCH_ASSOC);

            if ($conn->rowCount() > 0) {
                $user = $conn->fetch();

                if ( password_verify($password, $user['password']) ) {
                    $_SESSION['user_id'] = intval($user['user_id']);
                    $_SESSION['email'] = filter_var($user['email'], FILTER_SANITIZE_EMAIL);
                    return true;
                } else {
                    return false;
                }

            } else {
                return false;
            };

        } catch(PDOException $e) {
            return false;
        }
            
    }

    /**
     * Check if username is available
     * @param string $login User username
     * @return bool
     */
    public function isLoginAvailable($login) {

        $sql = "SELECT *
                FROM `users`
                WHERE `login` = '$login'";
        $result = $this->db->query($sql);
        if ($result->rowCount() > 0) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Hash password
     * @param string $password User password
     * @return bool|string
     */
    private function passwordHash($password) {
        return password_hash($password, PASSWORD_BCRYPT);
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
?>