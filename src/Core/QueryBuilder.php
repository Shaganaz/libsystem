<?php
namespace Src\Core;
use PDO;
class QueryBuilder{
    protected $pdo;
    protected $table;
    protected $where = '';
    protected $limit;
    protected $offset;
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
    public function limit($limit) {
        $this->limit = intval($limit);
        return $this;
    }
    public function offset($offset) {
        $this->offset = intval($offset);
        return $this;
    }    
    public function whereLike(array $columns, $term) {
        $likeClauses = array_map(fn($col) => "$col LIKE ?", $columns);
        $this->where = "WHERE " . implode(' OR ', $likeClauses);
        $this->bindings = array_fill(0, count($columns), "%$term%");
        return $this;
    }    
    public function get(){
        $sql = "SELECT * FROM {$this->table}";
    
        if (!empty($this->where)) {
            $sql .= " {$this->where}";
        }
    
        if (isset($this->limit)) {
            $sql .= " LIMIT {$this->limit}";
        }
    
        if (isset($this->offset)) {
            $sql .= " OFFSET {$this->offset}";
        }
    
        $stmt = $this->pdo->prepare($sql);
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
    public function createTable($columns,$name) {
        $tableName = $name ?? $this->table;
        $cols = [];
        foreach ($columns as $col => $type) {
            $cols[] = "$col $type";
        }
        $colsSql = implode(',', $cols);
        $sql = "CREATE TABLE IF NOT EXISTS $tableName ($colsSql)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute();
    }
    public function count($column = '*') {
        $sql = "SELECT COUNT($column) as count FROM {$this->table}";
    
        if (!empty($this->where)) {
            $sql .= " {$this->where}";
        }
    
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($this->bindings);
    
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] ?? 0;
    }
    
}