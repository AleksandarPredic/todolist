<?php

namespace TodoList\Controllers;

use TodoList\Libs\Controller;

/**
 * Class Error_Controller - responsible for 404 page
 * @package TodoList\Controllers
 */
class Error_Controller extends Controller {

    /**
     * Default view
     */
    function index(){
        $this->view->render('error/error_404.php');
    }
}