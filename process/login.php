<?php
session_start();

require_once __DIR__ . '/../data/conex.php';
require_once __DIR__ . '/../classes/User.php';

$email = $_POST['email'] ?? '';
$pass = $_POST['password'] ?? '';

$email = trim($email);
$pass = trim($pass);

$user = User::login($email, $pass);

if ($user) {
  $_SESSION['user'] = [
    'id' => $user['id'],
    'name' => $user['name'],
    'email' => $user['email'],
    'role' => $user['role'],
  ];

  $destino = $user['role'] === 'admin' ? 'admin' : 'home';
  header('Location: ../index.php?vista=' . $destino);
  exit;
}

header('Location: ../index.php?vista=sesion&error=credenciales');
exit;
