<?php
require_once __DIR__ . '/../vendor/autoload.php';
use Src\Controller\BookController;
use Src\Controller\AuthController;
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];
$book = new BookController();
$auth = new AuthController();

if ($uri === '/books' && $method === 'GET') {
    $book->displayBooks();
} elseif ($uri === '/books/create' && $method === 'GET') {
    $book->addBook();
} elseif ($uri === '/books/save' && $method === 'POST') {
    $book->saveBook($_POST);
} elseif (preg_match('/\/books\/edit\/(\d+)/', $uri, $matches) && $method === 'GET') {
    $book->editBook($matches[1]);
} elseif (preg_match('/\/books\/update\/(\d+)/', $uri, $matches) && $method === 'POST') {
    $book->updateBook($_POST, $matches[1]);
} elseif (preg_match('/\/books\/search/', $uri) && $method === 'GET') {
    $book->search();
} elseif (preg_match('/\/books\/delete\/(\d+)/', $uri, $matches) && $method === 'GET') {
    $book->removeBook($matches[1]);
}

elseif ($uri === '/login' && $method === 'GET') {
    $auth->loginForm();
} elseif ($uri === '/login' && $method === 'POST') {
    $auth->login();
} elseif ($uri === '/logout' && $method === 'GET') {
    $auth->logout();
} elseif ($uri === '/forgot' && $method === 'GET') {
    $auth->forgotPasswordForm();
} elseif ($uri === '/forgot' && $method === 'POST') {
    $auth->sendResetLink();
} elseif ($uri === '/reset' && $method === 'GET') {
    $auth->resetPasswordForm();
} elseif ($uri === '/reset' && $method === 'POST') {
    $auth->resetPassword();
}
else {
    echo "404 Not Found";
}