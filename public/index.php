<?php
include_once '../vendor/autoload.php';

$dotenv = \Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

include_once '../config/database.php';
error_reporting(E_ALL);
set_error_handler("\\config\\Error::errorHandle");
set_exception_handler("\\config\\Error::exceptionHandle");

include_once '../routes/web.php';
\config\Router::Dispatch($_SERVER['REQUEST_URI']);
?>