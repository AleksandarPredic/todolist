<?php

namespace TodoList\Controllers;

use TodoList\Libs\Controller;

/**
 * Class Demo_Controller - responsible for creating tables in database
 * @package TodoList\Controllers
 */
class Demo_Controller extends Controller {

    /**
     * Default controler
     */
    public function index() {
        $this->view->render('demo/index.php');
    }

    /**
     * Drop and create tables in database
     */
    public function refreshDbTables() {

        $result = $this->model->refreashTables();

        if ($result) {
            $this->redirect('users/registration', 'Database tables created! The Force is strong with you!');
        } else {
            $this->redirect('demo', 'Sorry but we couldn\'t create tables! The Force is weak today!');
        }

    }

}