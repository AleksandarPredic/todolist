<?php

namespace TodoList\Libs;

/**
 * Class Controller
 * @package TodoList\Libs
 */
class Controller {

    /**
     * View class object
     * @var object View
     */
    public $view;

    /**
     * Model for the appropriate controller
     * @var object
     */
    public $model;

    /**
     * Controller constructor. Set view and model for the MVC
     * @param string $name Model and Controller name
     */
    public function __construct($name = '') {
        $name = filter_var($name, FILTER_SANITIZE_STRING);
        $this->view = new View();
        $this->view->controllerName = $name;
        
        $path = BASE_PATH . 'models/' . $name . '_model.php';
        if(file_exists($path)) {
            include $path;
            $modelName = '\TodoList\Models\\' .ucfirst($name).'_Model';
            $this->model = new $modelName();
        }
    }

    /**
     * Generate nonce
     * @return string
     */
    protected function createNonce() {
        $nonce = uniqid(getenv('NONCE_PREFIX'));
        $_SESSION['nonce'] = $nonce;
        return $nonce;
    }

    /**
     * Check if nonce is valid
     * @param string $nonce
     * @return bool
     */
    protected function checkNonce( $nonce ) {

        // Check nonce
        if ( ( $_SESSION['nonce'] !== $nonce ) ) {
            return false;
        }

        return true;

    }

    /**
     * Set form fields values before form submission
     * @param $array
     * @use $_SESSION
     */
    protected function setOldFormValues($array) {
        $_SESSION['form_fields'] = $array;
    }

    /**
     * Redirect to page with message
     * @param string $path Relative url path
     * @param null $message Message to display
     */
    protected function redirect($path, $message = null) {
        $url = URL . $path;

        if ( $message ) {
            $url .= '?message=' . urlencode(strip_tags($message));
        }
        
        header('Location: ' .  $url);
        die();
    }

    /**
     * Check if user is logged in middleware or redirect to login page
     */
    protected function authUserMiddleware() {
        if (empty($_SESSION['user_id'] )) {
            $this->redirect('users/login');
        }
    }
    
}