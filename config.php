<?php
// https://packagist.org/packages/vlucas/phpdotenv
$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();

define('URL', getenv('URL'));
define('ADMIN_URL', URL . 'admin/');

$basePath = realpath(dirname(__FILE__)) . '/';
define('BASE_PATH', $basePath);
define('LIBS', BASE_PATH.'libs/');