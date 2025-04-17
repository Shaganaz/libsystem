<?php
namespace Src\Controller;
use Src\Model\Book;
class Bookcontroller{
    protected $book;
    public function __construct(){
        $this->book=new Book();
    }
    public function displaybooks(){
        $books=$this->book->selectAll();
        $this->renderView('book/index',['books'=>$books]);
    }
    public function addBook(){
        $this->renderView('book/add');
    }
    public function saveBook($data){
        $this->book->insertbook($data);
        header('Location:/books');
        exit;
    }
    public function removeBook($id){
        $this->book->deleteBook($id);
        header('Location: /books');
        exit;
    }
    protected function renderView($viewPath, $data = []){
        extract($data); 
        require_once __DIR__ . "/../Views/{$viewPath}.php";
    }
}