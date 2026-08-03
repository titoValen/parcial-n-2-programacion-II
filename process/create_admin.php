<?php
require_once __DIR__ . '/../middleware/admin_guard.php'; // corta acá si no es admin

require_once __DIR__ . '/../data/conex.php';
require_once __DIR__ . '/../classes/User.php';

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if ($name === '' || $email === '' || $password === '') {
  header('Location: ../index.php?vista=admin&error=admin_incompleto');
  exit;
}

if (User::emailExists($email)) {
  header('Location: ../index.php?vista=admin&error=admin_email_existente');
  exit;
}

$id = User::createAdmin($name, $email, $password);

if (!$id) {
  header('Location: ../index.php?vista=admin&error=admin_no_creado');
  exit;
}

header('Location: ../index.php?vista=admin&ok=admin_creado');
exit;
