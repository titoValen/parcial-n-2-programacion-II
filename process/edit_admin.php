<?php
require_once __DIR__ . '/../middleware/admin_guard.php';
require_once __DIR__ . '/../data/conex.php';
require_once __DIR__ . '/../classes/User.php';

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$role = trim($_POST['role'] ?? '');
$password = trim($_POST['password'] ?? '');

if (!$id || $name === '' || $email === '' || $role === '') {
  header('Location: ../index.php?vista=admin&error=admin_incompleto');
  exit;
}

$admin = User::getById($id);
if (!$admin || ($admin->getRole() ?? null) !== 'admin') {
  header('Location: ../index.php?vista=admin&error=admin_no_encontrado');
  exit;
}

if ($role !== 'admin' && User::countAdmins() <= 1) {
  header('Location: ../index.php?vista=admin&error=admin_unico');
  exit;
}

$actualizado = User::updateAdmin($id, $name, $email, $role, $password !== '' ? $password : null);

if (!$actualizado) {
  header('Location: ../index.php?vista=admin&error=admin_no_actualizado');
  exit;
}

if (isset($_SESSION['user']) && (int) $_SESSION['user']['id'] === $id) {
  $_SESSION['user']['name'] = $name;
  $_SESSION['user']['role'] = $role;
}

$vistaDestino = 'admin';
if (isset($_SESSION['user']) && (int) $_SESSION['user']['id'] === $id && $role !== 'admin') {
  $vistaDestino = 'home';
}

header('Location: ../index.php?vista=' . $vistaDestino . '&ok=admin_actualizado');
exit;
