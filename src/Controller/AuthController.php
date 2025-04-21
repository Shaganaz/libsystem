<?php
namespace Src\Controller;
use Src\Model\User;
class AuthController {
    protected $user;
    public function __construct() {
        $this->user = new User();
        session_start();
    }
    public function registerForm() {
        $token=$_GET['token'] ?? '';
        $this->renderView('user/register', ['token'=>$token]);
    } 
    public function register() {
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $existing = $this->user->getByEmail($email);
        if ($existing) {
            echo "User already exists with that email.";
            return;
        }   
        $this->user->createUser([
            'name' => $name,
            'email' => $email,
            'password' => $hashedPassword,
        ]);  
        header('Location: /login');
        exit;
    }    
    public function loginForm() {
        $this->renderView('user/login');
    }
    public function login() {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $user = $this->user->getByEmail($email)[0] ?? null;
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user;
            echo "success";
            return;
        }
        echo "Invalid email or password.";
    }   
    public function logout() {
        session_destroy();
        header('Location: /login');
        exit;
    }
    public function forgotPasswordForm() {
        $this->renderView('user/forgotpass');
    }
    public function sendResetLink() {
        $email = $_POST['email'] ?? '';
        $user = $this->user->getByEmail($email)[0] ?? null;
        if ($user) {
            $token = bin2hex(random_bytes(16));
            $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
            $this->user->updateUser($user['id'],[
                'reset_token' => $token,
                'reset_token_expiry' => $expires
            ]);
            echo "Reset link: http://localhost/reset?token=$token";
        } else {
            echo "Email not found.";
        }
    }
    public function resetPasswordForm() {
        $this->renderView('user/resetpass');
    }
    public function resetPassword() {
        $token = $_POST['token'] ?? '';
        $password = $_POST['password'] ?? '';
        $user = $this->user->getByResetToken($token)[0] ?? null;
        if ($user && strtotime($user['reset_token_expiry']) > time()) {
            $newPass = password_hash($password, PASSWORD_DEFAULT);
            $this->user->updateUser($user['id'], [
                'password' => $newPass,
                'reset_token' => null,
                'reset_token_expiry' => null
            ]);
            echo "Password has been reset.";
        } else {
            echo "Invalid or expired token.";
        }
    }
    protected function renderView($view, $data = []) {
        extract($data);
        require_once __DIR__ . '/../View/' . $view . '.php';


    }
}