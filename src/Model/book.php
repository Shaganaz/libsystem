<?php
namespace Src\Model;
use Src\Core\DB;
use Src\Core\QueryBuilder;
class Books{
    protected $db;
    protected $query;

    public function __construct(){
        $this->db = new database();
        $this->query = new querybuilder($this->db->getConnection());
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
}