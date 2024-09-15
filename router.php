<?php

use Services\PostService;

require 'vendor/autoload.php';
$first_url = $_SERVER['REQUEST_URI'];
$first_url = preg_replace('#/+#', '/', $first_url);
$first_url = trim($first_url, '/');
$parts = explode('/', $first_url, 3);
$url = isset($parts[1]) ? $parts[1] : '';
$id = isset($_GET['id']) ? $_GET['id'] : '';

use Services\Validation;
use Controllers\UserController;
use Controllers\PostController;
use Services\ENV;
use Services\Database;
use Services\UserService;

// Instantiate necessary services
$env = new ENV();
$database = new Database();
$dbConnection = $database->get_connection(); // Get the DB connection
$userService = new UserService($dbConnection, new Validation()); // Pass the Validation service
$postService = new PostService($dbConnection, new Validation());

// Instantiate the controller with dependencies
$userController = new UserController($env, $database, $userService);
$PostController = new PostController($env, $database, $postService);

switch ($url) {
    case 'login':
        $userController->login();
        break;
    case 'register':
        $userController->register();
        break;
    case 'store':
        $userController->store();
        break;
    case 'authenticate':
        $userController->authenticate();
        break;
    case 'logout':
        $userController->logout();
        break;
    case 'posts':
        $PostController->index();
        break;
    case 'create_post':
        $PostController->create();
        break;
    default:
        include 'views/404.php';
}
