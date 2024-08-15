<?php

require __DIR__ . '/../vendor/autoload.php';

use MiniMarkPlace\Libraries\Routing;
use MiniMarkPlace\Libraries\Database;
use MiniMarkPlace\Controllers\ProductCategoryController;

$database = new Database();
$router   = new Routing();
$controller = new ProductCategoryController();

$router->add('GET', '/', function() {
    return 'Welcome to Our Website!';
});

$router->add('GET', '/about', function() {
    return 'Our website is a Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.';
});

$router->add('GET', '/product-category', [ProductCategoryController::class, 'show']);
$router->add('POST', '/product-category', [ProductCategoryController::class, 'store']);
$router->add('PUT', '/product-category', [ProductCategoryController::class, 'update']);
$router->add('DELETE', '/product-category', [ProductCategoryController::class, 'delete']);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PSR4-AUTOLOAD</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@^2.0/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 text-gray-900">
    <header class="bg-blue-600 text-white p-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-bold">PSR4-AUTOLOAD</h1>
            <nav>
                <a href="/" class="px-3 py-2 hover:bg-blue-700 rounded">Home</a>
                <a href="/about" class="px-3 py-2 hover:bg-blue-700 rounded">About</a>
                <a href="/product-category" class="px-3 py-2 hover:bg-blue-700 rounded">Product Categories</a>
            </nav>
        </div>
    </header>
    <main class="container mx-auto p-4">
        <?php
        $output = $router->run();
        echo $output;
        ?>
    </main>
</body>
</html>
