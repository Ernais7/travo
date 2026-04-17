<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

require_once __DIR__ . '/../config/config.php';

require_once __DIR__ . '/../app/Core/Autoloader.php';
Autoloader::register();

$router = new Router();
require_once __DIR__ . '/../config/routes.php';

$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
