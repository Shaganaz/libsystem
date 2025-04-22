<?php
namespace Src\Controller;
use Src\Model\Book;
class BookController{
    protected $book;
    public function __construct(){
        $this->book=new Book();
    }
    public function displaybooks() {
        $page = $_GET['page'] ?? 1;
        $perPage = 15;
        $offset = ($page - 1) * $perPage;
    
        $books = $this->book->getBooksPaginated($perPage, $offset);
        $totalBooks = $this->book->countBooks();
        $totalPages = ceil($totalBooks / $perPage);
    
        $this->renderView('books/index', [
            'books'=> $books,
            'currentPage' => $page,
            'totalPages' => $totalPages
        ]);
    }    
    public function addBook(){
        $this->renderView('books/add');
    }
    public function saveBook($data){
        $this->book->insertBook($data);
        header('Location:/books');
        exit;
    }
    public function editBook($id){
        $book=$this->book->find($id);
        $this->renderView('books/edit', ['book'=>$book]);

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
        $term = $_POST['term'] ?? '';
        $results = $this->book->search($term);
        header('Content-Type: application/json');
        echo json_encode($results);
    }
    protected function renderView($view, $data = []){
        extract($data); 
        require_once __DIR__ . '/../View/'  . $view. '.php';
    }
}