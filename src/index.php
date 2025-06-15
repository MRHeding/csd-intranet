<?php
require_once 'config/database.php';
require_once 'middleware/AuthMiddleware.php';

session_start();

// Check if user is logged in (except for auth actions)
$controller = $_GET['controller'] ?? 'Auth';
$action = $_GET['action'] ?? 'login';

// Allow access to auth controller without login
if ($controller !== 'Auth' && !isset($_SESSION['user_id'])) {
    header('Location: ?controller=Auth&action=login');
    exit;
}

// If user is logged in and trying to access auth login or register, redirect to dashboard
if ($controller === 'Auth' && ($action === 'login' || $action === 'register') && isset($_SESSION['user_id'])) {
    header('Location: ?controller=Dashboard&action=dashboard');
    exit;
}

$controller = ucfirst($controller);
$controllerFile = "controllers/{$controller}Controller.php";

if (file_exists($controllerFile)) {
    require_once $controllerFile;
    $controllerClass = "{$controller}Controller";
    
    if (class_exists($controllerClass)) {
        $controllerInstance = new $controllerClass();
        
        if (method_exists($controllerInstance, $action)) {
            call_user_func([$controllerInstance, $action]);
        } else {
            // Redirect to 404 or error page
            http_response_code(404);
            echo "<h1>404 - Action not found</h1>";
            echo "<p>The requested action '$action' does not exist in the '$controller' controller.</p>";
            echo "<a href='?controller=Dashboard&action=dashboard'>Go to Dashboard</a>";
        }
    } else {
        http_response_code(500);
        echo "<h1>500 - Controller class not found</h1>";
        echo "<p>The controller class '$controllerClass' does not exist.</p>";
    }
} else {
    // Redirect to 404 or error page
    http_response_code(404);
    echo "<h1>404 - Controller not found</h1>";
    echo "<p>The requested controller '$controller' does not exist.</p>";
    echo "<a href='?controller=Dashboard&action=dashboard'>Go to Dashboard</a>";
}
?>