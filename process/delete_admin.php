<?php
require_once __DIR__ . '/../middleware/admin_guard.php';
require_once __DIR__ . '/../data/conex.php';
require_once __DIR__ . '/../classes/User.php';

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

if (!$id) {
  header('Location: ../index.php?vista=admin&error=admin_invalido');
  exit;
}

$admin = User::getById($id);
if (!$admin || ($admin->getRole() ?? null) !== 'admin') {
  header('Location: ../index.php?vista=admin&error=admin_no_encontrado');
  exit;
}

if (User::countAdmins() <= 1) {
  header('Location: ../index.php?vista=admin&error=admin_unico');
  exit;
}

$eliminado = User::deleteAdmin($id);
if (!$eliminado) {
  header('Location: ../index.php?vista=admin&error=admin_no_eliminado');
  exit;
}

$esSesionActual = isset($_SESSION['user']) && (int) $_SESSION['user']['id'] === $id;
if ($esSesionActual) {
  session_unset();
  session_destroy();
  header('Location: ../index.php?vista=home&ok=admin_eliminado');
  exit;
}

header('Location: ../index.php?vista=admin&ok=admin_eliminado');
exit;
