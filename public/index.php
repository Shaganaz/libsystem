<?php
require_once __DIR__ . '/../vendor/autoload.php';
use Src\Controller\BookController;
use Src\Controller\AuthController;
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];
$book = new BookController();
$auth = new AuthController();
if ($uri === '/' && $method === 'POST') {
    header('Location: /login');
    exit;
} elseif ($uri === '/books' && $method === 'POST') {
    $book->displaybooks();
} elseif ($uri === '/books/create' && $method === 'POST') {
    $book->addBook();
} elseif ($uri === '/books/save' && $method === 'POST') {
    $book->saveBook($_POST);
} elseif (preg_match('/\/books\/edit\/(\d+)/', $uri, $matches) && $method === 'POST') {
    $book->editBook($matches[1]);
} elseif (preg_match('/\/books\/update\/(\d+)/', $uri, $matches) && $method === 'POST') {
    $book->updateBook($_POST, $matches[1]);
} elseif (preg_match('/\/books\/search/', $uri) && $method === 'POST') {
    $book->search();
} elseif (preg_match('/\/books\/delete\/(\d+)/', $uri, $matches) && $method === 'DELETE') {
    $book->removeBook($matches[1]);
}

elseif ($uri == '/register' && $method == 'POST') {
    $auth->registerForm();
} elseif ($uri == '/register' && $method == 'POST') {
    $auth->register();
} elseif ($uri === '/login' && $method === 'POST') {
    $auth->loginForm();
} elseif ($uri === '/login' && $method === 'POST') {
    $auth->login();
} elseif ($uri === '/logout' && $method === 'POST') {
    $auth->logout();
} elseif ($uri === '/forgot' && $method === 'POST') {
    $auth->forgotPasswordForm();
} elseif ($uri === '/forgot' && $method === 'POST') {
    $auth->sendResetLink();
} elseif ($uri === '/reset' && $method === 'POST') {
    $auth->resetPasswordForm();
} elseif ($uri === '/reset' && $method === 'POST') {
    $auth->resetPassword();
} 
else {
    echo "404 Not Found";
}