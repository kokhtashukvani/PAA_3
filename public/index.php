<?php

// Basic front controller

// Show all errors for development
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Load configuration and core files
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../src/core/db.php';
require_once __DIR__ . '/../src/core/helpers.php';
require_once __DIR__ . '/../src/core/router.php';

// Start the session for the entire application
session_start();

// Get the requested URI
$request_uri = $_SERVER['REQUEST_URI'];

// Get the route from our router function
$route = handle_request($request_uri);

// Build controller class name and path
$controllerName = ucfirst($route['controller']);
$controllerClass = $controllerName;
$controllerFile = __DIR__ . '/../src/controllers/' . $controllerClass . '.php';

if (file_exists($controllerFile)) {
    require_once $controllerFile;
    if (class_exists($controllerClass)) {
        $controllerInstance = new $controllerClass();
        $action = $route['action'];

        if (method_exists($controllerInstance, $action)) {
            // Call the controller's action method, passing URL parameters
            $params = $route['params'] ?? [];
            $controllerInstance->$action(...$params);
        } else {
            http_response_code(404);
            load_view('errors/404');
        }
    } else {
        http_response_code(404);
        load_view('errors/404');
    }
} else {
    http_response_code(404);
    load_view('errors/404');
}
