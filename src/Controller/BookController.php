<?php
namespace Src\Controller;
use Src\Model\Book;
class BookController{
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
        $this->book->insertBook($data);
        header('Location:/books');
        exit;
    }
    public function editBook($id){
        $book=$this->book->find($id);
        $this->renderView('book/edit', ['book'=>$book]);

    }
    public function updateBook($postData,$id){
        $this->book->updateBook($postData,$id);
        echo json_encode(['message' => 'Book updated successfully']);
    }
    public function removeBook($id){
        $this->book->deleteBook($id);
        header('Location: /books');
        exit;
    }
    public function search(){
        $term = $_GET['term'] ?? '';
        $results = $this->book->search($term);
        header('Content-Type: application/json');
        echo json_encode($results);
    }
    protected function renderView($viewPath, $data = []){
        extract($data); 
        require_once __DIR__ . "/../Views/{$viewPath}.php";
    }
}