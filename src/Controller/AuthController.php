<?php
namespace Src\Controller;
use Src\Model\User;
class AuthController {
    protected $user;
    public function __construct() {
        $this->user = new User();
        session_start();
    }
    public function loginForm() {
        $this->renderView('auth/login');
    }
    public function login() {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $user = $this->user->getByEmail($email)[0] ?? null;
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user;
            header('Location: /dashboard');
            exit;
        }
        echo "Invalid email or password.";
    }
    public function logout() {
        session_destroy();
        header('Location: /login');
        exit;
    }
    public function forgotPasswordForm() {
        $this->renderView('auth/forgot');
    }
    public function sendResetLink() {
        $email = $_POST['email'] ?? '';
        $user = $this->user->getByEmail($email)[0] ?? null;
        if ($user) {
            $token = bin2hex(random_bytes(16));
            $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
            $this->user->update($user['id'],[
                'reset_token' => $token,
                'reset_token_expiry' => $expires
            ]);
            echo "Reset link: http://localhost/reset?token=$token";
        } else {
            echo "Email not found.";
        }
    }
    public function resetPasswordForm() {
        $this->renderView('auth/reset');
    }
    public function resetPassword() {
        $token = $_POST['token'] ?? '';
        $password = $_POST['password'] ?? '';
        $user = $this->user->getByToken($token)[0] ?? null;
        if ($user && strtotime($user['reset_token_expiry']) > time()) {
            $newPass = password_hash($password, PASSWORD_DEFAULT);
            $this->user->update($user['id'], [
                'password' => $newPass,
                'reset_token' => null,
                'reset_token_expiry' => null
            ]);
            echo "Password has been reset.";
        } else {
            echo "Invalid or expired token.";
        }
    }
    protected function renderView($viewPath, $data = []) {
        extract($data);
        require_once __DIR__ . "/../Views/{$viewPath}.php";
    }
}