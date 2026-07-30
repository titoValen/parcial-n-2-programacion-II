<?php
session_start();

require_once __DIR__ . '/../data/conex.php';
require_once __DIR__ . '/../classes/User.php';

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$address = trim($_POST['address'] ?? '');
$phone = trim($_POST['phone'] ?? '');

if ($name === '' || $email === '' || $password === '') {
  header('Location: ../index.php?vista=sesion&error=incompleto');
  exit;
}

if (User::emailExists($email)) {
  header('Location: ../index.php?vista=sesion&error=email_existente');
  exit;
}

$id = User::register($name, $email, $password, $address, $phone);

if (!$id) {
  header('Location: ../index.php?vista=sesion&error=registro_fallido');
  exit;
}

// Logueamos automáticamente al usuario recién registrado
$_SESSION['user'] = [
  'id' => $id,
  'name' => $name,
  'email' => $email,
  'role' => 'cliente',
];

header('Location: ../index.php?vista=home');
exit;
