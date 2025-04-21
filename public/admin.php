<?php
require_once __DIR__ . '/../vendor/autoload.php';
echo "<pre>";
use Src\Model\User;
$user = new User();
$admin = [
    'name' => 'Admin',
    'email' => 'admin@example.com',
    'password' => password_hash('admin123', PASSWORD_DEFAULT),
    'role' => 'admin'
];
$existing = $user->UserEmail($admin['email']);
if ($existing) {
    echo "Admin already exists.";
} else {
    $user->createUser($admin);
    echo "Admin user created successfully. Email: admin@example.com , Password: admin123";
}
