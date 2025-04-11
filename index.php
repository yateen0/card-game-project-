<?php
// Autoloading for controllers and models
spl_autoload_register(function ($class_name) {
    $directories = [
        'controllers' => __DIR__ . '/controllers/',
        'models' => __DIR__ . '/models/'
    ];

    foreach ($directories as $directory) {
        $file = $directory . $class_name . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Get the action and optional ID from the URL
$action = isset($_GET['action']) ? $_GET['action'] : 'index';
$id = isset($_GET['id']) ? $_GET['id'] : null;

// Routing logic
if ($action === 'index' || $action === '') {
    $controller = new PostController();
    $controller->index();
} elseif ($action === 'create') {
    $controller = new PostController();
    $controller->create();
} elseif ($action === 'detail' && $id) {
    $controller = new PostController();
    $controller->detail($id);
} elseif ($action === 'register' || $action === 'login') {
    $userController = new UserController();
    if ($action === 'register') {
        $userController->register();
    } elseif ($action === 'login') {
        $userController->login();
    }
} else {
    echo "404 - Page not found";
}
?>