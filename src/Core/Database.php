<?php
namespace Src\Core;
use PDO;
use PDOException;
class DB{
    protected $pdo;
    public function __construct(){
        try{
            $this->pdo = new PDO('mysql:host=localhost;dbname=library_system', 'root', 'Shaganaz@123');
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $e){
            die("DB connection failed: " . $e->getMessage());
        }
    }
    public function getConnection(){
        return $this->pdo;
    }
}