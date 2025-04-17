<?php
namespace Src\Model;
use Src\Core\DB;
use Src\Core\QueryBuilder;
class User {
    protected $db;
    protected $query;
    public function __construct() {
        $this->db = new DB();
        $this->query = new QueryBuilder($this->db->getConnection());
    }
    public function createUser($data) {
        return $this->query->table('users')->insert($data);
    }
    public function UserEmail($email) {
        return $this->query->table('users')->where('email', $email)->get();
    }
    public function getByResetToken($token) {
        return $this->query->table('users')->where('reset_token', $token)->get();
    }
    public function getAllUser() {
        return $this->query->table('users')->get();
    }
    public function updateUser($id, $data) {
        return $this->query->table('users')->update($data, $id);
    }
    public function deleteUser($id) {
        return $this->query->table('users')->delete($id);
    }
}
