<?php
session_start();
session_name('predic_todo_list');

require dirname(__FILE__) . '/vendor/autoload.php';
require dirname(__FILE__) . '/config.php';

if ( 'dev' === getenv('ENVIROMENT') ) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0); // Disable all errors.
    ini_set('display_errors', 0);
}

require LIBS . 'Router.php';
require LIBS . 'Controller.php';
require LIBS . 'View.php';
require LIBS . 'Model.php';
require LIBS . 'Database.php';

$todolist = new \TodoList\Libs\Router();