<?php

namespace TodoList\Libs;

use TodoList\Libs\Home_Controller;

/**
 * Class Router - map url to MVC pattern
 * @package TodoList\Libs
 */
class Router {

    /**
     * Router constructor. Set current Controller
     * @param string $access
     */
    public function __construct($access = 'public') {

        $url = !empty($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : null;
        $url = trim($url,'/');
        $url = filter_var($url, FILTER_SANITIZE_URL);
        $url = explode('?', $url);
        $url = explode('/',$url[0]);

        $controller = !empty($url[0]) ? $url[0] : 'home';
        $function = !empty($url[1]) ? $url[1] : '';
        $parameter1 = !empty($url[2]) ? $url[2] : '';
/*
        if ( empty($_SESSION['user_id']) && $controller !== 'demo' ) {
            if ($function != 'login' && $function != 'registration' && $function != 'signIn' && $function != 'addUser') {
                header('Location: users/login');
                die();
            }
        }*/

        $file = BASE_PATH . 'controllers/' . $controller . '_controller.php';

        if (file_exists($file)) {
            require $file;
            $controllerName = '\TodoList\Controllers\\' . ucfirst($controller) . '_Controller';
            $controller = new $controllerName($controller);
        } else {
            $this->error404($access);
        }

        if (!empty($function)) {
            if (!method_exists($controller, $function)) {
                $this->error404($access);
            }
            if (!empty($parameter1)) {
                $controller->{$function}($parameter1);
            } else {
                $controller->{$function}();
            }
        } else {
            $controller->index();
        }
    }

    /**
     * 404 page Controller init
     * @param string $access
     */
    private function error404($access) {

        require BASE_PATH . 'controllers/error_controller.php';
        $controller = new \TodoList\Controllers\Error_Controller('error');
        $controller->index();
        die();
    }

}