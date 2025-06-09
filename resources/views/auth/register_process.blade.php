<?php
session_start();

// Simulasi rute sederhana
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($uri === '/' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    include 'views/welcome.php';
} elseif ($uri === '/dashboard' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_SESSION['user'])) {
        include 'views/dashboard.php';
    } else {
        header('Location: /login');
    }
} elseif ($uri === '/login' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    include 'views/login.php';
} elseif ($uri === '/login' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    // Proses login (contoh sederhana)
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    if ($username === 'admin' && $password === 'password') {
        $_SESSION['user'] = $username;
        header('Location: /dashboard');
    } else {
        header('Location: /login?error=invalid');
    }
} elseif ($uri === '/logout' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    session_destroy();
    header('Location: /');
} else {
    http_response_code(404);
    echo '404 Not Found';
}
