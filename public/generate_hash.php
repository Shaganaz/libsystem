<?php
$password = 'newpassword123';
$hash = password_hash($password, PASSWORD_DEFAULT);

echo "Plain: $password<br>";
echo "Hash: $hash";
