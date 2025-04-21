<?php
namespace Src\Model;
use Src\Core\DB;
use Src\Core\QueryBuilder;
class Book{
    protected $db;
    protected $query;
    public function __construct(){
        $this->db = new DB();
        $this->query = new QueryBuilder($this->db->getConnection());
    }
    public function getAllBooks(){
        return $this->query->table('books')->get();
    }
    public function insertBook($data){
        return $this->query->table('books')->insert($data);
    }
    public function deleteBook($id){
        return $this->query->table('books')->delete($id);
    }
    public function updateBook($data,$id){
        return $this->query->table('books')->update($data,$id);
    }
    public function search($term) {
        return $this->query
                    ->table('books')
                    ->whereLike(['title', 'author'], $term)
                    ->get();
    }    
    public function returnBook($id) {
        $results=$this->query->table('books')->where('id','$id')->get();
        return $results[0] ?? null;
    }
    public function getBooksPaginated($limit, $offset) {
        return $this->query->table('books')->limit($limit)->offset($offset)->get();
    }  
    public function countBooks() {
        return $this->query->table('books')->count();
    }
    
}