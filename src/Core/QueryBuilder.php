<?php
namespace Src\Core;
use PDO;
class QueryBuilder{
    protected $pdo;
    protected $table;
    protected $where = '';
    protected $bindings = [];
    public function __construct(PDO $connection){
        $this->pdo=$connection;
    }
    public function table($table){
        $this->table=$table;
        return $this;
    }
    public function where($column,$value){
        $this->where="where $column=?";
        $this->bindings=[$value];
        return $this;
    }
    public function get(){
        $sql="select * from {$this->table} {$this->where}";
        $stmt=$this->pdo->prepare($sql);
        $stmt->execute($this->bindings);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function insert($data) {
            $columns = implode(',', array_keys($data));
            $placeholders = implode(',', array_fill(0, count($data), '?'));
            $sql = "INSERT INTO {$this->table} ($columns) VALUES ($placeholders)";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute(array_values($data));    
    }
    public function update(array $data, $id) {
        $set = implode(', ', array_map(function ($key) {
            return "$key = ?";
        }, 
        array_keys($data)));
        $sql = "UPDATE {$this->table} SET $set WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([...array_values($data), $id]);
    }
    public function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }

}