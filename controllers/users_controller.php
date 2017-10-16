<?php

namespace TodoList\Controllers;

use TodoList\Libs\Controller;

/**
 * Class Users_Controller - responsible for users registration and login
 * @package TodoList\Controllers
 */
class Users_Controller extends Controller {

    /**
     * Current user id
     * @var int
     */
    private $user_id;

    /**
     * Users_Controller constructor.
     * @param string $name Model and Controller name
     */
    public function __construct($name = '')
    {
        parent::__construct($name);

        $this->user_id = isset( $_SESSION['user_id'] ) && !empty($_SESSION['user_id']);
    }

    /**
     * Default view
     */
    public function index(){
        // Silence is golden
    }

    /**
     * Login form view
     */
    public function login() {

        if ( ! $this->checkDbTables() ) {
            $this->redirect('demo/');
        }

        if ($this->user_id) {
            $this->redirect('');
        }

        $this->view->capthca = $this->createCaptcha();
        $this->view->nonce = $this->createNonce();
        $this->view->login = isset( $_SESSION['form_fields']['login'] ) ? $_SESSION['form_fields']['login'] : '';
        $this->view->render('users/login.php');
        unset($_SESSION['form_fields']);
    }

    /**
     * Register form view
     */
    public function registration() {

        if ( ! $this->checkDbTables() ) {
            $this->redirect('demo/');
        }

        if ($this->user_id) {
            $this->redirect('');
        }

        $this->view->capthca = $this->createCaptcha();
        $this->view->nonce = $this->createNonce();
        $this->view->login = isset( $_SESSION['form_fields']['login'] ) ? $_SESSION['form_fields']['login'] : '';
        $this->view->email = isset( $_SESSION['form_fields']['email'] ) ? $_SESSION['form_fields']['email'] : '';
        $this->view->render('users/registration.php');
        unset($_SESSION['form_fields']);
    }

    /**
     * Add new user
     */
    public function addUser() {

        $oldFormValues = array(
            'login' => isset($_POST['login']) && !empty($_POST['login']) ? $_POST['login'] : '',
            'email' => isset($_POST['email']) && !empty($_POST['email']) ? $_POST['email'] : ''
        );

        if (
            (!isset($_POST['login']) || empty($_POST['login']))
            || (!isset($_POST['password']) || empty($_POST['password']))
            || (!isset($_POST['password_confirm']) || empty($_POST['password_confirm']))
            || (!isset($_POST['email']) || empty($_POST['email']))
        ) {
            $this->setOldFormValues($oldFormValues);
            $this->redirect('users/registration', 'Please fill all form fields');
        }

        if ( !isset($_POST['captcha']) || ! $this->checkCaptcha($_POST['captcha']) ) {
            $this->setOldFormValues($oldFormValues);
            $this->redirect('users/registration', 'Captcha failure! Please try again!');
        }

        if ( !isset( $_POST['nonce'] ) || ! $this->checkNonce( $_POST['nonce'] ) ) {
            $this->setOldFormValues($oldFormValues);
            $this->redirect('users/registration', 'Security failure! Please try again!');
        }

        if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $this->setOldFormValues($oldFormValues);
            $this->redirect('users/registration', 'Invalid email!');
        }

        if ($_POST['password'] !== $_POST['password_confirm']) {
            $this->setOldFormValues($oldFormValues);
            $this->redirect('users/registration', 'Password confirm mismatch');
        }

        $user['login'] = $_POST['login'];
        $user['password'] = $_POST['password'];
        $user['email'] = $_POST['email'];

        if ($this->model->addUser($user)) {
            $this->redirect('users/login', 'Successful registration!!! But beware: Fear is the path to the dark side. Fear leads to anger; anger leads to hate; hate leads to suffering. I sense much fear in you.');
        } else {
            $this->redirect('users/registration', 'Registration failed, please try again with different username or email.');
        }

    }

    /**
     * Sign in user and create session
     */
    public function signIn() {

        $oldFormValues = array(
            'login' => isset($_POST['login']) && !empty($_POST['login']) ? $_POST['login'] : ''
        );

        if (
            ( !isset($_POST['login']) || empty($_POST['login']) )
            || (!isset($_POST['password']) || empty($_POST['password']))
        ) {
            $this->setOldFormValues($oldFormValues);
            $this->redirect('users/login', 'Please fill all form fields');
        }

        if ( !isset($_POST['captcha']) || ! $this->checkCaptcha($_POST['captcha']) ) {
            $this->setOldFormValues($oldFormValues);
            $this->redirect('users/login', 'Capthca failure! Please try again!');
        }

        if ( !isset( $_POST['nonce'] ) || ! $this->checkNonce( $_POST['nonce'] ) ) {
            $this->setOldFormValues($oldFormValues);
            $this->redirect('users/login', 'Security failure! Please try again');
        }

        if ($this->model->loginCheck($_POST['login'], $_POST['password']) ) {
            $this->redirect('', 'You are logged in. May the force be with you!');
        } else {
            $this->setOldFormValues($oldFormValues);
            $this->redirect('users/login', 'Login data error! Maybe you should register first.');
        }
    }

    /**
     * Logout user
     */
    public function logout() {
        unset($_SESSION);
        session_destroy();
        $this->redirect('users/login', 'You are logged out. May the force be with you!');
    }

    /**
     * Check if user login (username) exists
     * @param string $login
     */
    public function checkLogin($login) {
        
        echo (int)$this->model->isLoginAvailable($login);
    }

    /**
     * Generate captcha
     * @return string
     */
    private function createCaptcha() {
        $first = rand(0, 9);
        $second = rand(0, 9);
        $_SESSION['capthca'] = $first + $second;
        return "Prove you are not a Sit Lord: Calculate {$first} + {$second}?";
    }

    /**
     * Check if captcha is valid
     * @param string $captcha
     * @return bool
     */
    private function checkCaptcha( $captcha ) {
        // Check capthca
        if ( ( $_SESSION['capthca'] != $captcha ) ) {
            return false;
        }

        return true;
    }

    /**
     * Check if required tables exists
     * @return bool
     */
    private function checkDbTables() {

        return $this->model->verifyTables();

    }

}