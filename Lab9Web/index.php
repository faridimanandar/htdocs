<?php
declare(strict_types=1);
session_start();

require_once __DIR__ . '/helpers/functions.php';
require_once __DIR__ . '/config/database.php';

$routes = [
    'dashboard'  => __DIR__ . '/views/dashboard.php',
    'home'       => __DIR__ . '/views/home.php',
    'profil'     => __DIR__ . '/views/profil.php',
    'kontak'     => __DIR__ . '/views/kontak.php',
    'functions'  => __DIR__ . '/views/functions-demo.php',
    'user/list'  => __DIR__ . '/modules/user/list.php',
    'user/add'   => __DIR__ . '/modules/user/add.php',
    'user/edit'  => __DIR__ . '/modules/user/edit.php',
    'user/delete'=> __DIR__ . '/modules/user/delete.php',
    'login'      => __DIR__ . '/modules/auth/login.php',
    'logout'     => __DIR__ . '/modules/auth/logout.php',
];

$page = $_GET['page'] ?? 'dashboard';
if (!is_string($page) || !array_key_exists($page, $routes)) {
    http_response_code(404);
    $contentFile = __DIR__ . '/views/404.php';
    $page = '404';
} else {
    $contentFile = $routes[$page];
}

require __DIR__ . '/views/header.php';
require $contentFile;
require __DIR__ . '/views/footer.php';
