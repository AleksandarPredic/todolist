<?php
session_start();
session_name('predic_todo_list');

/**
 * Composer install required
 */
if ( ! file_exists( dirname(__FILE__) . '/vendor/autoload.php' ) ) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    throw new Exception('Vendor folder missing. Plese run composer install');
}

/**
 * Load vendor files
 */
require dirname(__FILE__) . '/vendor/autoload.php';

/**
 * Set error display
 */
$enviroment = getenv('ENVIROMENT');

if ( 'dev' === $enviroment || false === $enviroment ) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

if ( 'production' === $enviroment ) {
    error_reporting(0); // Disable all errors.
    ini_set('display_errors', 0);
}

/**
 * Require app files
 */
require dirname(__FILE__) . '/config.php';
require LIBS . 'Router.php';
require LIBS . 'Controller.php';
require LIBS . 'View.php';
require LIBS . 'Model.php';
require LIBS . 'Database.php';

/**
 * App init
 */
$todolist = new \TodoList\Libs\Router();