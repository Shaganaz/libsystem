<?php
namespace Src\Controller;
use Src\Model\User;
class UserController {
    protected $user;
    public function __construct() {
        $this->user = new User();
        session_start();
    }
    public function listUsers() {
        $users = $this->user->getAll();
        $this->render('user/list', ['users' => $users]);
    }
    public function deleteUsers($id) {
        if ($_SESSION['user']['role'] !== 'admin') {
            echo "Access denied.";
            return;
        }
        $this->user->delete($id);
        header('Location: /users');
        exit;
    }
    protected function render($view, $data = []) {
        extract($data);
        require_once __DIR__ . "/../Views/{$view}.php";
    }
}
