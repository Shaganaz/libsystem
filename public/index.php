<?php
require_once __DIR__ . '/../vendor/autoload.php';
use Src\Controller\BookController;
$uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];
$controller = new BookController();
if ($uri === '/books' && $method === 'GET') {
    $controller->displayBooks();
}elseif ($uri === '/books/create' && $method === 'GET') {
    $controller->addBook();
}elseif ($uri === '/books/save' && $method === 'POST') {
    $controller->saveBook($_POST);
}elseif (preg_match('/\/books\/delete\/(\d+)/', $uri, $matches) && $method === 'POST') {
    $controller->removeBook($matches[1]);
}else {
    echo "404 Not Found";
}